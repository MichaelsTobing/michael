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
 * @package    AdvancedReports
 * @version    2.8.5
 * @copyright  Copyright (c) 2020 Aheadworks Inc. (http://www.aheadworks.com)
 * @license    https://ecommerce.aheadworks.com/end-user-license-agreement/
 */
namespace Aheadworks\AdvancedReports\Controller\Adminhtml\SalesOverview;

use Aheadworks\AdvancedReports\Model\Url\Base64Coder;
use Aheadworks\AdvancedReports\Ui\Component\Listing\Breadcrumbs;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 *
 * @package Aheadworks\AdvancedReports\Controller\Adminhtml\SalesOverview
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Aheadworks_AdvancedReports::reports_salesoverview';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $paymentTypeName = $this->_request->getParam('payment_name');
        $couponCode = $this->_request->getParam('coupon_code');
        if ($couponCode) {
            $title = __('Sales Overview (%1)', Base64Coder::decode($couponCode));
        } elseif ($paymentTypeName) {
            $title = __('Sales Overview (%1)', Base64Coder::decode($paymentTypeName));
        } else {
            $title = __('Sales Overview');
        }
        $this->_session->setData(Breadcrumbs::BREADCRUMBS_CONTROLLER_TITLE, $title);
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Aheadworks_AdvancedReports::reports_salesoverview');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
