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
namespace Aheadworks\RewardPoints\Model\ResourceModel\EarnRate;

use Aheadworks\RewardPoints\Model\EarnRate;
use Aheadworks\RewardPoints\Model\ResourceModel\EarnRate as EarnRateResource;

/**
 * Class Aheadworks\RewardPoints\Model\ResourceModel\EarnRate\Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * {@inheritDoc}
     */
    protected function _construct()
    {
        $this->_init(EarnRate::class, EarnRateResource::class);
    }

    /**
     * Retrieve array of items for configuration page
     *
     * @return array
     */
    public function toConfigDataArray()
    {
        $arrItems = [];
        foreach ($this as $item) {
            $arrItems[] = $item->toArray([]);
        }
        return $arrItems;
    }
}
