<?php
namespace NS8\CSP\Controller\Adminhtml\Ajax;

use NS8\CSP\Helper\Config;
use NS8\CSP\Helper\Order;
use NS8\CSP\Helper\Logger;

class Hold extends \Magento\Backend\App\Action
{
    private $configHelper;
    private $orderHelper;
    private $logger;
    private $resultJsonFactory;
    private $context;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Config $configHelper,
        Order $orderHelper,
        Logger $logger,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        $this->logger = $logger;
        $this->orderHelper = $orderHelper;
        $this->configHelper = $configHelper;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->context = $context;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $params = $this->getRequest()->getParams();
            $order = null;

            if (isset($params["order_id"])) {
                $order = $this->orderHelper->getById($params["order_id"]);
            }

            if (isset($params["increment_id"])) {
                $order = $this->orderHelper->getByIncrementId($params["increment_id"]);
            }

            if (!isset($order)) {
                return $this->resultJsonFactory->create()->setData(['code' => 404, 'message' => 'No such order']);
            } else {
                $note = null;

                if (isset($params["note"]) && $params["note"] !== "") {
                    $note = $params["note"];
                }

                $auth = $this->context->getAuth();
                $loginUser = $auth->getUser();

                if ($order->getState() == 'holded') {
                    return $this->resultJsonFactory->create()->setData(
                        ['code' => 400, 'message' => 'Order is already On Hold.']
                    );
                }

                if (!$order->canHold()) {
                    return $this->resultJsonFactory->create()->setData(
                        ['code' => 400, 'message' => 'Cannot hold order']
                    );
                }

                $this->orderHelper->hold($order->getEntityId(), $loginUser->getUserName(), $note);

                if (isset($params["successMessage"]) && $params["successMessage"] !== "") {
                    $this->messageManager->addSuccess(__($params["successMessage"]));
                }

                //  return state and status
                $order = $this->orderHelper->getById($order->getEntityId());

                return $this->resultJsonFactory->create()->setData([
                    'code' => 200,
                    'message' => 'Order On Hold.',
                    'state' => $order->getState(),
                    'status' => $order->getStatus()
                ]);
            }
        } catch (\Exception $e) {
            $this->logger->error('hold', $e->getMessage(), $params);
            return $this->resultJsonFactory->create()->setData(['code' => 400, 'message' => $e->getMessage()]);
        }
    }
}
