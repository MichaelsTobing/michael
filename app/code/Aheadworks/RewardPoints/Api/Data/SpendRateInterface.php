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
namespace Aheadworks\RewardPoints\Api\Data;

/**
 * @api
 */
interface SpendRateInterface
{
    /**#@+
     * Constants for keys of data array.
     * Identical to the name of the getter in snake case
     */
    const RATE_ID = 'rate_id';
    const WEBSITE_ID = 'website_id';
    const CUSTOMER_GROUP_ID = 'customer_group_id';
    const LIFETIME_SALES_AMOUNT = 'lifetime_sales_amount';
    const POINTS = 'points';
    const BASE_AMOUNT = 'base_amount';
    /**#@-*/

    /**
     * Set ID
     *
     * @param  int $id
     * @return SpendRateInterface
     */
    public function setId($id);

    /**
     * Get ID
     *
     * @return int
     */
    public function getId();

    /**
     * Set website id
     *
     * @param  int $websiteId
     * @return SpendRateInterface
     */
    public function setWebsiteId($websiteId);

    /**
     * Get website id
     *
     * @return int
     */
    public function getWebsiteId();

    /**
     * Set customer gorup id
     *
     * @param  int $customerGroupId
     * @return SpendRateInterface
     */
    public function setCustomerGroupId($customerGroupId);

    /**
     * Get customer gorup id
     *
     * @return int
     */
    public function getCustomerGroupId();

    /**
     * Set lifetime sales amount
     *
     * @param  int $lifetimeSalesAmount
     * @return SpendRateInterface
     */
    public function setLifetimeSalesAmount($lifetimeSalesAmount);

    /**
     * Get lifetime sales amount
     *
     * @return int
     */
    public function getLifetimeSalesAmount();

    /**
     * Set points
     *
     * @param  int $points
     * @return SpendRateInterface
     */
    public function setPoints($points);

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints();

    /**
     * Set base amount
     *
     * @param  float $baseAmount
     * @return SpendRateInterface
     */
    public function setBaseAmount($baseAmount);

    /**
     * Get base amount
     *
     * @return float
     */
    public function getBaseAmount();
}
