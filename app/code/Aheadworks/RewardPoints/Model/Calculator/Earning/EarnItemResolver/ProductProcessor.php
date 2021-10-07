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
namespace Aheadworks\RewardPoints\Model\Calculator\Earning\EarnItemResolver;

use Aheadworks\RewardPoints\Model\Calculator\Earning\EarnItemInterface;
use Aheadworks\RewardPoints\Model\Calculator\Earning\EarnItemResolver\ProductProcessor\TypeProcessorPool;
use Magento\Catalog\Model\Product;

/**
 * Class ProductProcessor
 * @package Aheadworks\RewardPoints\Model\Calculator\Earning\EarnItemResolver
 */
class ProductProcessor
{
    /**
     * @var TypeProcessorPool
     */
    private $typeProcessorPool;

    /**
     * @param TypeProcessorPool $typeProcessorPool
     */
    public function __construct(
        TypeProcessorPool $typeProcessorPool
    ) {
        $this->typeProcessorPool = $typeProcessorPool;
    }

    /**
     * Get earn items
     *
     * @param Product $product
     * @param $beforeTax
     * @return EarnItemInterface[]
     * @throws \Exception
     */
    public function getEarnItems($product, $beforeTax)
    {
        $typeProcessor = $this->typeProcessorPool->getProcessorByCode($product->getTypeId());

        return $typeProcessor->getEarnItems($product, $beforeTax);
    }
}
