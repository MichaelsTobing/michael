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
namespace Aheadworks\RewardPoints\Plugin\Model\Newsletter;

use Aheadworks\RewardPoints\Api\CustomerRewardPointsManagementInterface;
use Magento\Newsletter\Model\Subscriber;

/**
 * Class Aheadworks\RewardPoints\Plugin\Model\Newsletter\SubscriberPlugin
 */
class SubscriberPlugin
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
     * Add Reward Points for the first Newsletter signup
     *
     * @param Subscriber $subscriber
     * @return void
     */
    public function afterSave(Subscriber $subscriber)
    {
        $customerId = $subscriber->getCustomerId();
        if ($customerId && $subscriber->isSubscribed() && $subscriber->isObjectNew()) {
            $this->customerRewardPointsService->addPointsForNewsletterSignup($customerId);
        }
    }
}
