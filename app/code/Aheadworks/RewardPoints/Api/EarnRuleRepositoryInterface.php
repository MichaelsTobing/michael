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
namespace Aheadworks\RewardPoints\Api;

use Aheadworks\RewardPoints\Api\Data\EarnRuleInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface EarnRuleRepositoryInterface
 * @package Aheadworks\RewardPoints\Api
 * @api
 */
interface EarnRuleRepositoryInterface
{
    /**
     * Save rule
     *
     * @param EarnRuleInterface $rule
     * @return EarnRuleInterface
     * @throws CouldNotSaveException If validation fails
     */
    public function save(EarnRuleInterface $rule);

    /**
     * Retrieve rule with storefront labels for specified store view
     *
     * @param int $ruleId
     * @param int|null $storeId
     * @return EarnRuleInterface
     * @throws NoSuchEntityException If the rule does not exist
     */
    public function get($ruleId, $storeId = null);

    /**
     * Retrieve rules matching the specified criteria with storefront labels for specified store view
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param int|null $storeId
     * @return EarnRuleSearchResultsInterface
     * @throws LocalizedException if an error occurs
     */
    public function getList(SearchCriteriaInterface $searchCriteria, $storeId = null);

    /**
     * Delete rule
     *
     * @param EarnRuleInterface $rule
     * @return bool true on success
     * @throws NoSuchEntityException If the rule does not exist
     */
    public function delete(EarnRuleInterface $rule);

    /**
     * Delete rule by id
     *
     * @param int $ruleId
     * @return bool true on success
     * @throws NoSuchEntityException If the rule does not exist
     */
    public function deleteById($ruleId);
}
