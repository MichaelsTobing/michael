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
interface ProductShareInterface
{
    /**#@+
     * Constants for keys of data array.
     * Identical to the name of the getter in snake case
     */
    const SHARE_ID = 'share_id';
    const WEBSITE_ID = 'website_id';
    const CUSTOMER_ID = 'customer_id';
    const PRODUCT_ID = 'product_id';
    const NETWORK = 'network';
    /**#@-*/

    /**
     * Set ID
     *
     * @param  int $id
     * @return ProductShareInterface
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
     * @return ProductShareInterface
     */
    public function setWebsiteId($websiteId);

    /**
     * Get website id
     *
     * @return int
     */
    public function getWebsiteId();

    /**
     * Set customer id
     *
     * @param  int $customerId
     * @return ProductShareInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get customer id
     *
     * @return int
     */
    public function getCustomerId();

    /**
     * Set product id
     *
     * @param  int $productId
     * @return ProductShareInterface
     */
    public function setProductId($productId);

    /**
     * Get product id
     *
     * @return int
     */
    public function getProductId();

    /**
     * Set network
     *
     * @param  string $network
     * @return ProductShareInterface
     */
    public function setNetwork($network);

    /**
     * Get network
     *
     * @return string
     */
    public function getNetwork();
}
