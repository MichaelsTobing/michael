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
namespace Aheadworks\RewardPoints\Model\Source\EarnRule;

use Aheadworks\RewardPoints\Api\Data\EarnRuleInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 * @package Aheadworks\RewardPoints\Model\Source\EarnRule
 */
class Status implements OptionSourceInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $this->options = [
                [
                    'value' => EarnRuleInterface::STATUS_DISABLED,
                    'label' => __('Disabled')
                ],
                [
                    'value' => EarnRuleInterface::STATUS_ENABLED,
                    'label' => __('Enabled')
                ]
            ];
        }
        return $this->options;
    }
}
