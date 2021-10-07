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

use Aheadworks\RewardPoints\Api\Data\PointsSummaryInterface;

/**
 * @api
 */
interface PointsSummaryRepositoryInterface
{
    /**
     * Retrieve points summary data by id
     *
     * @param  int $id
     * @return PointsSummaryInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * Retrieve points summary data by customer id
     *
     * @param  int $customerId
     * @return PointsSummaryInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($customerId);

    /**
     * Create new instance
     *
     * @return PointsSummaryInterface
     */
    public function create();

    /**
     * Save points summary data
     *
     * @param  PointsSummaryInterface $pointsSummary
     * @return PointsSummaryInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(PointsSummaryInterface $pointsSummary);

    /**
     * Delete points summary by id
     *
     * @param  int $id
     * @return boolean
     */
    public function deleteById($id);

    /**
     * Delete points summary data
     *
     * @param  PointsSummaryInterface $pointsSummary
     * @return boolean
     */
    public function delete(PointsSummaryInterface $pointsSummary);
}
