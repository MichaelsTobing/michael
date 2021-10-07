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
namespace Aheadworks\RewardPoints\Model\Source\Category;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Aheadworks\RewardPoints\Model\Source\Category|AllowSpendingPoints
 */
class AllowSpendingPoints implements ArrayInterface
{
    const CATEGORY_SPENDING_OPTION_CATEGORY_ONLY = 'category_only';
    const CATEGORY_SPENDING_OPTION_CATEGORY_WITH_SUB = 'category_with_sub';
    const CATEGORY_SPENDING_OPTION_NO_CATEGORY = 'category_no';
    const CATEGORY_SPENDING_OPTION_NO_CATEGORY_WITH_SUB = 'category_with_sub_no';
    // Default value
    const CATEGORY_SPENDING_OPTION_CATEGORY_DEFAULT = 'category_only';

    /**
     * @var array
     */
    private $options;

    /**
     *  {@inheritDoc}
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $this->options = [
                [
                    'value' => self::CATEGORY_SPENDING_OPTION_CATEGORY_ONLY,
                    'label' => 'Yes, that category only'
                ],
                [
                    'value' => self::CATEGORY_SPENDING_OPTION_CATEGORY_WITH_SUB,
                    'label' => 'Yes, that category and its subcategories'
                ],
                [
                    'value' => self::CATEGORY_SPENDING_OPTION_NO_CATEGORY,
                    'label' => 'No, this category only'
                ],
                [
                    'value' => self::CATEGORY_SPENDING_OPTION_NO_CATEGORY_WITH_SUB,
                    'label' => 'No, this category and its subcategories'
                ]
            ];
        }
        return $this->options;
    }
}
