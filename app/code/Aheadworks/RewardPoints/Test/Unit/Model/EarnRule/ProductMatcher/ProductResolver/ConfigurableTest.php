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
namespace Aheadworks\RewardPoints\Test\Unit\Model\EarnRule\ProductMatcher\ProductResolver;

use Aheadworks\RewardPoints\Model\EarnRule\ProductMatcher\ProductResolver\Configurable;
use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableType;

/**
 * Test for \Aheadworks\RewardPoints\Model\EarnRule\ProductMatcher\ProductResolver\Configurable
 */
class ConfigurableTest extends TestCase
{
    /**
     * @var Configurable
     */
    private $resolver;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);

        $this->resolver = $objectManager->getObject(Configurable::class, []);
    }

    /**
     * Test getProductsForValidation method
     */
    public function testGetProductsForValidation()
    {
        $parentProductMock = $this->createMock(Product::class);
        $childProductFirstMock = $this->createMock(Product::class);
        $childProductSecondMock = $this->createMock(Product::class);
        $childProducts = [$childProductFirstMock, $childProductSecondMock];
        $resultProducts = [$childProductFirstMock, $childProductSecondMock, $parentProductMock];

        $configurableTypeMock = $this->createMock(ConfigurableType::class);

        $parentProductMock->expects($this->once())
            ->method('getTypeInstance')
            ->willReturn($configurableTypeMock);

        $configurableTypeMock->expects($this->once())
            ->method('getUsedProducts')
            ->willReturn($childProducts);

        $this->assertEquals($resultProducts, $this->resolver->getProductsForValidation($parentProductMock));
    }
}
