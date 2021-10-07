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
namespace Aheadworks\RewardPoints\Model\Calculator\Earning\EarnItemResolver\RawItemProcessor;

use Magento\Sales\Api\Data\CreditmemoInterface;
use Magento\Sales\Model\Order\Creditmemo\Item as CreditmemoItem;

/**
 * Class CreditmemoProcessor
 * @package Aheadworks\RewardPoints\Model\Calculator\Earning\EarnItemResolver\RawItemProcessor
 */
class CreditmemoProcessor
{
    /**
     * @var CreditmemoItemsResolver
     */
    private $creditmemoItemsResolver;

    /**
     * @var ItemGroupConverterInterface
     */
    private $itemGroupConverter;

    /**
     * @param CreditmemoItemsResolver $creditmemoItemsResolver
     * @param ItemGroupConverterInterface $itemGroupConverter
     */
    public function __construct(
        CreditmemoItemsResolver $creditmemoItemsResolver,
        ItemGroupConverterInterface $itemGroupConverter
    ) {
        $this->creditmemoItemsResolver = $creditmemoItemsResolver;
        $this->itemGroupConverter = $itemGroupConverter;
    }

    /**
     * @param CreditmemoInterface $creditmemo
     * @return array [ItemInterface[], ...]
     */
    public function getItemGroups($creditmemo)
    {
        /** @var CreditmemoItem[] $creditmemoItems */
        $creditmemoItems = $this->creditmemoItemsResolver->getItems($creditmemo);
        $creditmemoItemGroups = $this->getCreditmemoItemsGrouped($creditmemoItems);
        $itemGroups = $this->itemGroupConverter->convert($creditmemoItemGroups);

        return $itemGroups;
    }

    /**
     * Get creditmemo items grouped
     *
     * @param CreditmemoItem[] $creditmemoItems
     * @return array
     */
    private function getCreditmemoItemsGrouped($creditmemoItems)
    {
        $creditmemoGroups = [];
        /** @var CreditmemoItem $quoteItem */
        foreach ($creditmemoItems as $creditmemoItem) {
            $parentItemId = $creditmemoItem->getParentItemId();
            if ($parentItemId == null) {
                $parentItemId = $creditmemoItem->getItemId();
            }
            $creditmemoGroups[$parentItemId][$creditmemoItem->getItemId()] = $creditmemoItem;
        }
        return $creditmemoGroups;
    }
}
