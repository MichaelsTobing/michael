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
namespace Aheadworks\RewardPoints\Model;

use Aheadworks\RewardPoints\Api\Data\StorefrontLabelsInterface;
use Magento\Framework\Api\AbstractExtensibleObject;

/**
 * Class StorefrontLabels
 *
 * @package Aheadworks\RewardPoints\Model
 * @codeCoverageIgnore
 */
class StorefrontLabels extends AbstractExtensibleObject implements StorefrontLabelsInterface
{
    /**
     * {@inheritdoc}
     */
    public function getStoreId()
    {
        return $this->_get(self::STORE_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getProductPromoText()
    {
        return $this->_get(self::PRODUCT_PROMO_TEXT);
    }

    /**
     * {@inheritdoc}
     */
    public function setProductPromoText($productPromoText)
    {
        return $this->setData(self::PRODUCT_PROMO_TEXT, $productPromoText);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryPromoText()
    {
        return $this->_get(self::CATEGORY_PROMO_TEXT);
    }

    /**
     * {@inheritdoc}
     */
    public function setCategoryPromoText($categoryPromoText)
    {
        return $this->setData(self::CATEGORY_PROMO_TEXT, $categoryPromoText);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     */
    public function setExtensionAttributes(
        \Aheadworks\RewardPoints\Api\Data\StorefrontLabelsExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
