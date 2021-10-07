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
namespace Aheadworks\RewardPoints\Model\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class SubscribeStatus
 *
 * @package Aheadworks\RewardPoints\Model\Source
 */
class SubscribeStatus implements ArrayInterface
{
    /**#@+
     * Subscribe status values
     */
    const SUBSCRIBED = 1;
    const NOT_SUBSCRIBED = 2;
    const UNSUBSCRIBED = 3;
    /**#@-*/

    /**
     *  {@inheritDoc}
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::SUBSCRIBED,
                'label' => __('Subscribed')
            ],
            [
                'value' => self::NOT_SUBSCRIBED,
                'label' => __('Not Subscribed')
            ],
            [
                'value' => self::UNSUBSCRIBED,
                'label' => __('Unsubscribed')
            ]
        ];
    }
}
