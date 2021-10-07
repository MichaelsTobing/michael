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
namespace Aheadworks\RewardPoints\Model\Source\Transaction;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class EntityType
 *
 * @package Aheadworks\RewardPoints\Model\Source
 */
class EntityType implements OptionSourceInterface
{
    /**#@+
     * Entity type values
     */
    const ORDER_ID = 1;
    const CREDIT_MEMO_ID = 2;
    const TRANSACTION_ID = 3;
    const EARN_RULE_ID = 4;
    /**#@-*/

    /**
     * {@inheritDoc}
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::ORDER_ID,
                'label' => __('Order Id')
            ],
            [
                'value' => self::CREDIT_MEMO_ID,
                'label' => __('Credit Memo Id')
            ],
            [
                'value' => self::TRANSACTION_ID,
                'label' => __('Transaction Id')
            ],
            [
                'value' => self::EARN_RULE_ID,
                'label' => __('Earning Rule Id')
            ]
        ];
    }

    /**
     * Retrieve entity types
     *
     * @return array
     */
    public function getEntityTypes()
    {
        return [
            self::ORDER_ID,
            self::CREDIT_MEMO_ID,
            self::TRANSACTION_ID,
            self::EARN_RULE_ID
        ];
    }
}
