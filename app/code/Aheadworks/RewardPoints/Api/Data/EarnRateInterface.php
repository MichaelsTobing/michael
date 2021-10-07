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
interface EarnRateInterface
{
    /**#@+
     * Constants for keys of data array.
     * Identical to the name of the getter in snake case
     */
    const RATE_ID = 'rate_id';
    const WEBSITE_ID = 'website_id';
    const CUSTOMER_GROUP_ID = 'customer_group_id';
    const LIFETIME_SALES_AMOUNT = 'lifetime_sales_amount';
    const BASE_AMOUNT = 'base_amount';
    const POINTS = 'points';
    /**#@-*/

    /**
     * Set ID
     *
     * @param  int $id
     * @return EarnRateInterface
     */
    public function setId($id);

    /**
     * Get ID
     *
     * @return int
     */
    public function getId();

    /**
     * Get website id
     *
     * @param  int $websiteId
     * @return EarnRateInterface
     */
    public function setWebsiteId($websiteId);

    /**
     * Set website id
     *
     * @return int
     */
    public function getWebsiteId();

    /**
     * Set customer group id
     *
     * @param  int $customerGroupId
     * @return EarnRateInterface
     */
    public function setCustomerGroupId($customerGroupId);

    /**
     * Get customer group id
     *
     * @return int
     */
    public function getCustomerGroupId();

    /**
     * Set lifetime sales amount
     *
     * @param  int $lifetimeSalesAmount
     * @return EarnRateInterface
     */
    public function setLifetimeSalesAmount($lifetimeSalesAmount);

    /**
     * Get lifetime sales amount
     *
     * @return int
     */
    public function getLifetimeSalesAmount();

    /**
     * Set base amount
     *
     * @param  float $baseAmount
     * @return EarnRateInterface
     */
    public function setBaseAmount($baseAmount);

    /**
     * Get base amount
     *
     * @return float
     */
    public function getBaseAmount();

    /**
     * Set points
     *
     * @param  int $points
     * @return EarnRateInterface
     */
    public function setPoints($points);

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints();
}
