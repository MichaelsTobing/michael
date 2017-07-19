<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2017 Amasty (https://www.amasty.com)
 * @package Amasty_Promo
 */

namespace Amasty\Promo\Model\Rule\Action\Discount;

/**
 * Action name: Auto add the same product
 */
class SameProduct extends AbstractDiscount
{
    /**
     * {@inheritdoc}
     */
    protected function _addFreeItems(
        \Magento\SalesRule\Model\Rule $rule,
        \Magento\Quote\Model\Quote\Item\AbstractItem $item,
        $qty
    ) {
        if ($this->promoItemHelper->isPromoItem($item)) {
            return;
        }

        $discountStep   = max(1, $rule->getDiscountStep());
        $discountAmount = max(1, $rule->getDiscountAmount());
        $maxDiscountQty = 100000;
        if ($rule->getDiscountQty()) {
            $maxDiscountQty = (int) max(1, $rule->getDiscountQty());
        }

        $qty = min(
            floor($item->getQty() / $discountStep) * $discountAmount,
            $maxDiscountQty
        );

        if ($item->getParentItemId()) {
            return;
        }

        if ($item['product_type'] == 'downloadable') {
            return;
        }

        if ($qty < 1) {
            return;
        }

        if ($this->_skip($rule, $item)) {
            return;
        }

        $this->promoRegistry->addPromoItem(
            $item->getProduct()->getData('sku'),
            $qty,
            $rule->getId()
        );
    }
}
