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
namespace Aheadworks\RewardPoints\Model\EarnRule\Action\Processor;

use Aheadworks\RewardPoints\Model\Action\AttributeProcessor;
use Aheadworks\RewardPoints\Model\EarnRule\Action\ProcessorInterface as ActionProcessorInterface;

/**
 * Class FixedAmount
 * @package Aheadworks\RewardPoints\Model\EarnRule\Action\Processor
 */
class FixedAmount implements ActionProcessorInterface
{
    /**
     * @var AttributeProcessor
     */
    private $attributeProcessor;

    /**
     * @param AttributeProcessor $attributeProcessor
     */
    public function __construct(
        AttributeProcessor $attributeProcessor
    ) {
        $this->attributeProcessor = $attributeProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function process($value, $qty, $attributes)
    {
        $amount = $this->attributeProcessor->getAttributeValueByCode('amount', $attributes);
        if (is_numeric($amount)) {
            $value += ($amount * $qty);
        }

        return $value;
    }
}
