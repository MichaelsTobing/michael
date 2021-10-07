<?php
/**
 * Aheadworks Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://ecommerce.aheadworks.com/end-user-license-agreement/
 *
 * @package    SocialLogin
 * @version    1.6.3
 * @copyright  Copyright (c) 2020 Aheadworks Inc. (http://www.aheadworks.com)
 * @license    https://ecommerce.aheadworks.com/end-user-license-agreement/
 */
namespace Aheadworks\SocialLogin\Controller\Account;

use Aheadworks\SocialLogin\Controller\AbstractAction;

/**
 * Class AbstractLogin
 */
abstract class AbstractLogin extends AbstractAction
{
    /**
     * @var \Aheadworks\SocialLogin\Model\ProviderManagement
     */
    protected $providerManagement;

    /**
     * @var \Aheadworks\SocialLogin\Helper\State
     */
    protected $stateHelper;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Aheadworks\SocialLogin\Model\Config\General $generalConfig
     * @param \Aheadworks\SocialLogin\Model\ProviderManagement $providerManagement
     * @param \Aheadworks\SocialLogin\Helper\State $stateHelper
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Psr\Log\LoggerInterface $logger,
        \Aheadworks\SocialLogin\Model\Config\General $generalConfig,
        \Aheadworks\SocialLogin\Model\ProviderManagement $providerManagement,
        \Aheadworks\SocialLogin\Helper\State $stateHelper,
        \Magento\Customer\Model\Session $customerSession
    ) {
        parent::__construct($context, $logger, $generalConfig);
        $this->providerManagement = $providerManagement;
        $this->stateHelper = $stateHelper;
        $this->customerSession = $customerSession;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $providerCode = $this->getRequest()->getParam('provider');

        try {
            $factory = $this->providerManagement->getEnabledFactory($providerCode);

            $this->customerSession->setBeforeAuthUrl($this->_redirect->getRefererUrl());
            $response = $factory->createLoginRequestProcessor()
                ->process($factory->createService(), $this->getRequest());
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), $this->getRequest()->getParams());
            $this->messageManager->addErrorMessage(__('Something went wrong.'));
            $response = $this->resultRedirectFactory->create()->setPath('/');
        }

        return $response;
    }
}
