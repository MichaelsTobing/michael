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
namespace Aheadworks\RewardPoints\Model\Repository;

use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection as FrameworkAbstractCollection;

/**
 * Interface CollectionProcessorInterface
 * @package Aheadworks\RewardPoints\Model\Repository
 */
interface CollectionProcessorInterface
{
    /**
     * Process collection
     *
     * @param SearchCriteria $searchCriteria
     * @param FrameworkAbstractCollection $collection
     * @return void
     */
    public function process($searchCriteria, $collection);
}
