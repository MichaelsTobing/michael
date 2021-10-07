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
namespace Aheadworks\RewardPoints\Model\StorefrontLabelsEntity\Store;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Resolver
 *
 * @package Aheadworks\RewardPoints\Model\StorefrontLabelsEntity\Store
 */
class Resolver
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * Resolve store id which used for loading current storefront description
     *
     * @param int|null $storeId
     * @return int|null
     */
    public function getStoreIdForCurrentLabels($storeId)
    {
        try {
            $storeIdForCurrentLabels = isset($storeId) ? $storeId : $this->storeManager->getStore()->getId();
        } catch (NoSuchEntityException $exception) {
            $storeIdForCurrentLabels = null;
        }
        return $storeIdForCurrentLabels;
    }
}
