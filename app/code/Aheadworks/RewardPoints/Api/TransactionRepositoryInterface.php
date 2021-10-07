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

use Aheadworks\RewardPoints\Api\Data\TransactionInterface;
use Aheadworks\RewardPoints\Api\Data\TransactionSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * @api
 */
interface TransactionRepositoryInterface
{
    /**
     * Retrieve transaction data by id
     *
     * @param  int $id
     * @param  bool $cached
     * @return TransactionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id, $cached = true);

    /**
     * Create transaction instance
     *
     * @return TransactionInterface
     */
    public function create();

    /**
     * Save transaction data
     *
     * @param TransactionInterface $transaction
     * @param array $arguments
     * @return TransactionInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(TransactionInterface $transaction, $arguments = []);

    /**
     * Retrieve transaction matching the specified criteria
     *
     * @param  SearchCriteriaInterface $criteria
     * @return TransactionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria);
}
