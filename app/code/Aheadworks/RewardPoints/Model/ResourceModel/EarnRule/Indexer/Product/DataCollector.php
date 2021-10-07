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
namespace Aheadworks\RewardPoints\Model\ResourceModel\EarnRule\Indexer\Product;

use Aheadworks\RewardPoints\Api\Data\EarnRuleInterface;
use Aheadworks\RewardPoints\Api\EarnRuleManagementInterface;
use Aheadworks\RewardPoints\Model\Indexer\EarnRule\ProductLoader;
use Aheadworks\RewardPoints\Model\ResourceModel\EarnRule\Indexer\Product\DataCollector\RuleProcessor;

/**
 * Class DataCollector
 * @package Aheadworks\RewardPoints\Model\ResourceModel\EarnRule\Indexer\Product
 */
class DataCollector
{
    /**
     * @var EarnRuleManagementInterface
     */
    private $earnRuleManagement;

    /**
     * @var RuleProcessor
     */
    private $ruleProcessor;

    /**
     * @var ProductLoader
     */
    private $productLoader;

    /**
     * @param EarnRuleManagementInterface $earnRuleManagement
     * @param RuleProcessor $ruleProcessor
     * @param ProductLoader $productLoader
     */
    public function __construct(
        EarnRuleManagementInterface $earnRuleManagement,
        RuleProcessor $ruleProcessor,
        ProductLoader $productLoader
    ) {
        $this->earnRuleManagement = $earnRuleManagement;
        $this->ruleProcessor = $ruleProcessor;
        $this->productLoader = $productLoader;
    }

    /**
     * Get full index data
     *
     * @return array
     * phpcs:disable Magento2.Performance.ForeachArrayMerge
     */
    public function getAllData()
    {
        /** @var EarnRuleInterface[] $rules */
        $rules = $this->earnRuleManagement->getActiveRules();
        $result = [];
        foreach ($rules as $rule) {
            $data = $this->ruleProcessor->getAllMatchingProductsData($rule);
            $result = array_merge($result, $data);
        }
        return $result;
    }

    /**
     * Get index data for specified product ids
     *
     * @param int[] $productIds
     * @return array
     * phpcs:disable Magento2.Performance.ForeachArrayMerge
     */
    public function getDataToUpdate($productIds)
    {
        $rules = $this->earnRuleManagement->getActiveRules();
        $products = $this->productLoader->getProducts($productIds);
        $result = [];
        foreach ($rules as $rule) {
            foreach ($products as $product) {
                $data = $this->ruleProcessor->getMatchingProductData($rule, $product);
                $result = array_merge($result, $data);
            }
        }
        return $result;
    }
}
