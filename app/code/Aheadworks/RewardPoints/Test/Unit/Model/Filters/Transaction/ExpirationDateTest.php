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
namespace Aheadworks\RewardPoints\Test\Unit\Model\Filters\Transaction;

use Aheadworks\RewardPoints\Model\Filters\Transaction\ExpirationDate;
use Aheadworks\RewardPoints\Model\DateTime;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Class Aheadworks\RewardPoints\Test\Unit\Model\Filters\Transaction\ExpirationDateTest
 */
class ExpirationDateTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ExpirationDate
     */
    private $object;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|DateTime
     */
    private $dateTimeMock;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);

        $this->dateTimeMock = $this->getMockBuilder(DateTime::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'getDate',
                    'getTodayDate',
                    'getExpirationDate',
                ]
            )
            ->getMockForAbstractClass();

        $data = [
            'dateTime' => $this->dateTimeMock,
        ];
        $this->object = $this->objectManager->getObject(ExpirationDate::class, $data);
    }

    /**
     * Test filter method for null value
     */
    public function testFilterMethodsNullValue()
    {
        $this->assertNull($this->object->filter(null));
        $this->assertNull($this->object->filter(''));
        $this->assertEmpty($this->object->filter([]));
    }

    /**
     * Test filter method input date value
     */
    public function testFilterMethodInputDate()
    {
        $date = '2016-11-01';
        $expectedDate = '2016-11-01 12:30:41AM';

        $this->dateTimeMock->expects($this->once())
            ->method('getTodayDate')
            ->willReturn(0);

        $this->dateTimeMock->expects($this->exactly(2))
            ->method('getDate')
            ->with($date)
            ->willReturn($expectedDate);

        $this->assertEquals($expectedDate, $this->object->filter($date));
    }

    /**
     * Test filter method input string throw exception
     */
    public function testFilterMethodInputStringThrowException()
    {
        $date = 'test_string';

        $this->dateTimeMock->expects($this->once())
            ->method('getDate')
            ->with($date)
            ->willThrowException(
                new LocalizedException(
                    __('Invalid input date format %1', $date)
                )
            );

        $this->expectException(LocalizedException::class);

        $this->object->filter($date);
    }

    /**
     * Test filter method for expire_in_x_days and null expire value
     */
    public function testFilterMethodExpireInDaysNullValue()
    {
        $data = [
            'dateTime' => $this->dateTimeMock,
            'config' => [
                ExpirationDate::FIELD_EXPIRE => 'expire_in_x_days'
            ],
        ];
        $object = $this->objectManager->getObject(ExpirationDate::class, $data);
        $this->assertNull($object->filter(5));
    }

    /**
     * Test filter method with expiration in x days
     */
    public function testFilterMethodExpirationInXdays()
    {
        $date = '2016-11-01 12:30:41AM';

        $data = [
            'dateTime' => $this->dateTimeMock,
            'config' => [
                ExpirationDate::FIELD_EXPIRE => 'expire_in_x_days',
                ExpirationDate::FIELD_EXPIRE_IN_DAYS => 5
            ],
        ];
        $object = $this->objectManager->getObject(ExpirationDate::class, $data);

        $this->dateTimeMock->expects($this->once())
            ->method('getExpirationDate')
            ->with(5)
            ->willReturn($date);

        $this->dateTimeMock->expects($this->exactly(2))
            ->method('getDate')
            ->with($date)
            ->willReturn($date);

        $this->assertEquals($date, $object->filter(''));
    }
}
