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
namespace Aheadworks\RewardPoints\Test\Unit\Model\Calculator\Earning\EarnItemResolver\ProductProcessor;

use Aheadworks\RewardPoints\Model\Calculator\Earning\EarnItemResolver\ProductProcessor\CatalogPriceCalculator;
use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Catalog\Model\Product;

/**
 * Test for \Aheadworks\RewardPoints\Model\Calculator\Earning\EarnItemResolver\ProductProcessor\CatalogPriceCalculator
 */
class CatalogPriceCalculatorTest extends TestCase
{
    /**
     * @var CatalogPriceCalculator
     */
    private $catalogPriceCalculator;

    /**
     * @var CatalogHelper|\PHPUnit_Framework_MockObject_MockObject
     */
    private $catalogHelperMock;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);

        $this->catalogHelperMock = $this->createMock(CatalogHelper::class);

        $this->catalogPriceCalculator = $objectManager->getObject(
            CatalogPriceCalculator::class,
            [
                'catalogHelper' => $this->catalogHelperMock,
            ]
        );
    }

    /**
     * Test getFinalPriceAmount method
     *
     * @param bool $excludeTax
     * @param bool $includeTax
     * @dataProvider getFinalPriceAmountDataProvider
     */
    public function testGetFinalPriceAmount($excludeTax, $includeTax)
    {
        $productMock = $this->createMock(Product::class);
        $price = 55.5;
        $resultPrice = 60.5;

        $this->catalogHelperMock->expects($this->once())
            ->method('getTaxPrice')
            ->with($productMock, $price, $includeTax, null, null, null, null, null, true)
            ->willReturn($resultPrice);

        $this->assertEquals(
            $resultPrice,
            $this->catalogPriceCalculator->getFinalPriceAmount($productMock, $price, $excludeTax)
        );
    }

    /**
     * @return array
     */
    public function getFinalPriceAmountDataProvider()
    {
        return [
            ['excludeTax' => true, 'includeTax' => false],
            ['excludeTax' => false, 'includeTax' => true],
        ];
    }
}
