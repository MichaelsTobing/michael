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
namespace Aheadworks\RewardPoints\Model\Indexer\EarnRule;

/**
 * Interface ProductInterface
 * @package Aheadworks\RewardPoints\Model\Indexer\EarnRule
 */
interface ProductInterface
{
    /**#@+
     * Constants for keys of indexer fields.
     */
    const ID                        = 'id';
    const RULE_ID                   = 'rule_id';
    const FROM_DATE                 = 'from_date';
    const TO_DATE                   = 'to_date';
    const CUSTOMER_GROUP_ID         = 'customer_group_id';
    const WEBSITE_ID                = 'website_id';
    const PRODUCT_ID                = 'product_id';
    const PRIORITY                  = 'priority';
    /**#@-*/
}
