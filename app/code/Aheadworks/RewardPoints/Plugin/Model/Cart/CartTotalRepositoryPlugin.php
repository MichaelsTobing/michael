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
namespace Aheadworks\RewardPoints\Plugin\Model\Cart;

use Magento\Quote\Api\Data\TotalsExtensionFactory;
use Magento\Quote\Api\Data\TotalsInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Cart\CartTotalRepository as TotalRepository;
use Magento\Quote\Model\Quote;

/**
 * Class Aheadworks\RewardPoints\Plugin\Model\Cart\CartTotalRepositoryPlugin
 */
class CartTotalRepositoryPlugin
{
    /**
     * @var CartRepositoryInterface
     */
    private $quoteRepository;

    /**
     * @var TotalsExtensionFactory
     */
    private $totalsExtensionFactory;

    /**
     * @param CartRepositoryInterface $quoteRepository
     * @param TotalsExtensionFactory $totalsExtensionFactory
     */
    public function __construct(
        CartRepositoryInterface $quoteRepository,
        TotalsExtensionFactory $totalsExtensionFactory
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->totalsExtensionFactory = $totalsExtensionFactory;
    }

    /**
     * Apply extension attributes to totals
     *
     * @param TotalRepository $subject
     * @param \Closure $proceed
     * @param int $cartId
     * @return TotalsInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundGet(TotalRepository $subject, \Closure $proceed, $cartId)
    {
         /** @var TotalsInterface $totals */
        $totals = $proceed($cartId);

        /** @var \Magento\Quote\Api\Data\TotalsExtensionInterface $extensionAttributes */
        $extensionAttributes = $totals->getExtensionAttributes()
            ? $totals->getExtensionAttributes()
            : $this->totalsExtensionFactory->create();

        /** @var Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        if ($quote->isVirtual()) {
            $addressTotalsData = $quote->getBillingAddress()->getData();
        } else {
            $addressTotalsData = $quote->getShippingAddress()->getData();
        }
        $extensionAttributes->setAwRewardPointsAmount($quote->getAwRewardPointsAmount());
        $extensionAttributes->setBaseAwRewardPointsAmount($quote->getBaseAwRewardPointsAmount());
        $extensionAttributes->setAwRewardPoints($quote->getAwRewardPoints());
        $extensionAttributes->setAwRewardPointsDescription($quote->getAwRewardPointsDescription());
        $extensionAttributes->setAwRewardPointsShippingAmount(0);
        $extensionAttributes->setBaseAwRewardPointsShippingAmount(0);
        $extensionAttributes->setAwRewardPointsShipping(0);
        if (isset($addressTotalsData['aw_reward_points_shipping_amount'])
            && isset($addressTotalsData['base_aw_reward_points_shipping_amount'])
            && isset($addressTotalsData['aw_reward_points_shipping'])
        ) {
            $extensionAttributes->setAwRewardPointsShippingAmount(
                $addressTotalsData['aw_reward_points_shipping_amount']
            );
            $extensionAttributes->setBaseAwRewardPointsShippingAmount(
                $addressTotalsData['base_aw_reward_points_shipping_amount']
            );
            $extensionAttributes->setAwRewardPointsShipping(
                $addressTotalsData['aw_reward_points_shipping']
            );
        }
        $totals->setExtensionAttributes($extensionAttributes);
        return $totals;
    }
}
