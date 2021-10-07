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
namespace Aheadworks\RewardPoints\Model\StorefrontLabelsEntity;

use Aheadworks\RewardPoints\Api\Data\StorefrontLabelsEntityInterface;
use Magento\Framework\Validator\AbstractValidator;
use Aheadworks\RewardPoints\Ui\Component\Listing\Columns\Store\Options as StoreOptions;

/**
 * Class Validator
 *
 * @package Aheadworks\RewardPoints\Model\StorefrontLabelsEntity
 */
class Validator extends AbstractValidator
{
    /**
     * Returns true if and only if entity that contains storefront labels meets the validation requirements
     *
     * @param StorefrontLabelsEntityInterface $storefrontLabelsEntity
     * @return bool
     */
    public function isValid($storefrontLabelsEntity)
    {
        $this->_clearMessages();

        return ($this->isLabelsDataValid($storefrontLabelsEntity));
    }

    /**
     * Returns true if and only if storefront labels data is correct
     *
     * @param StorefrontLabelsEntityInterface $storefrontLabelsEntity
     * @return bool
     */
    private function isLabelsDataValid($storefrontLabelsEntity)
    {
        $isAllStoreViewsDataPresents = false;
        $labelsStoreIds = [];
        if ($storefrontLabelsEntity->getLabels() && (is_array($storefrontLabelsEntity->getLabels()))) {
            /** @var \Aheadworks\RewardPoints\Api\Data\StorefrontLabelsInterface $labelsRecord */
            foreach ($storefrontLabelsEntity->getLabels() as $labelsRecord) {
                if (!in_array($labelsRecord->getStoreId(), $labelsStoreIds)) {
                    array_push($labelsStoreIds, $labelsRecord->getStoreId());
                } else {
                    $this->_addMessages(['Duplicated store view in storefront descriptions found.']);
                    return false;
                }
                if ($labelsRecord->getStoreId() == StoreOptions::ALL_STORE_VIEWS) {
                    $isAllStoreViewsDataPresents = true;
                }
            }
        }
        if (!$isAllStoreViewsDataPresents) {
            $this->_addMessages(
                ['Default values of storefront descriptions (for All Store Views option) aren\'t set.']
            );
            return false;
        }
        return true;
    }
}
