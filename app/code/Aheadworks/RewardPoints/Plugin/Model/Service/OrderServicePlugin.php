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
 * @package    RewardPoints
 * @version    1.7.2
 * @copyright  Copyright (c) 2020 Aheadworks Inc. (http://www.aheadworks.com)
 * @license    https://ecommerce.aheadworks.com/end-user-license-agreement/
 */
namespace Aheadworks\RewardPoints\Plugin\Model\Service;

use Aheadworks\RewardPoints\Api\CustomerRewardPointsManagementInterface;
use Magento\Sales\Model\Service\OrderService;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Class Aheadworks\RewardPoints\Plugin\Model\Service\OrderServicePlugin
 */
class OrderServicePlugin
{
    /**
     * @var CustomerRewardPointsManagementInterface
     */
    private $customerRewardPointsService;

    /**
     * @param CustomerRewardPointsManagementInterface $customerRewardPointsService
     */
    public function __construct(
        CustomerRewardPointsManagementInterface $customerRewardPointsService
    ) {
        $this->customerRewardPointsService = $customerRewardPointsService;
    }

    /**
     * Spend customer Reward Points on checkout after cancel order
     *
     * @param OrderService $subject
     * @param \Closure $proceed
     * @param int $orderId
     * @return OrderInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundCancel($subject, \Closure $proceed, $orderId)
    {
        $result = $proceed($orderId);
        if ($result) {
            $this->customerRewardPointsService->reimbursedSpentRewardPointsOrderCancel($orderId);
        }

        return $result;
    }

    /**
     * Spend customer points on checkout after place order
     *
     * @param OrderService $subject
     * @param OrderInterface $result
     * @return OrderInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterPlace(OrderService $subject, OrderInterface $result)
    {
        $this->customerRewardPointsService->spendPointsOnCheckout($result->getEntityId());

        return $result;
    }
}
