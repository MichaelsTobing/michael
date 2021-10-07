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
namespace Aheadworks\RewardPoints\Model\Action;

use Aheadworks\RewardPoints\Api\Data\ActionInterface;
use Aheadworks\RewardPoints\Model\Action;
use Aheadworks\RewardPoints\Api\Data\ActionInterfaceFactory;
use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\Api\AttributeInterfaceFactory;

/**
 * Class Converter
 * @package Aheadworks\RewardPoints\Model\Action
 */
class Converter
{
    /**
     * @var ActionInterfaceFactory
     */
    private $actionFactory;

    /**
     * @var AttributeInterfaceFactory
     */
    private $attributeFactory;

    /**
     * @param ActionInterfaceFactory $actionFactory
     * @param AttributeInterfaceFactory $attributeFactory
     */
    public function __construct(
        ActionInterfaceFactory $actionFactory,
        AttributeInterfaceFactory $attributeFactory
    ) {
        $this->actionFactory = $actionFactory;
        $this->attributeFactory = $attributeFactory;
    }

    /**
     * Convert array into data model
     *
     * @param array $data
     * @return ActionInterface
     */
    public function arrayToDataModel($data)
    {
        /** @var ActionInterface $dataModel */
        $dataModel = $this->actionFactory->create();
        foreach ($data as $key => $value) {
            switch ($key) {
                case Action::TYPE:
                    $dataModel->setType($value);
                    break;
                case Action::ATTRIBUTES:
                    $attributes = [];
                    /** @var string[] $attribute */
                    foreach ($value as $attributeCode => $attributeValue) {
                        /** @var AttributeInterface $attribute */
                        $attribute = $this->attributeFactory->create();
                        $attribute
                            ->setAttributeCode($attributeCode)
                            ->setValue($attributeValue);
                        $attributes[] = $attribute;
                    }
                    $dataModel->setAttributes($attributes);
                    break;
                default:
            }
        }
        return $dataModel;
    }

    /**
     * Convert action data model into array
     *
     * @param ActionInterface $dataModel
     * @return array
     */
    public function dataModelToArray(ActionInterface $dataModel)
    {
        $data = [
           Action::TYPE => $dataModel->getType(),
        ];
        $attributes = [];
        foreach ($dataModel->getAttributes() as $attribute) {
            $attributes[$attribute->getAttributeCode()] = $attribute->getValue();
        }
        $data[Action::ATTRIBUTES] = $attributes;

        return $data;
    }
}
