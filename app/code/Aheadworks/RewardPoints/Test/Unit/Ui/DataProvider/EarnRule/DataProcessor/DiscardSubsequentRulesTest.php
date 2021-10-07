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
namespace Aheadworks\RewardPoints\Test\Unit\Ui\DataProvider\EarnRule\DataProcessor;

use Aheadworks\RewardPoints\Ui\DataProvider\EarnRule\DataProcessor\DiscardSubsequentRules;
use Aheadworks\RewardPoints\Api\Data\EarnRuleInterface;
use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\RewardPoints\Ui\DataProvider\EarnRule\DataProcessor\DiscardSubsequentRules
 */
class DiscardSubsequentRulesTest extends TestCase
{
    /**
     * @var Status
     */
    private $processor;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);

        $this->processor = $objectManager->getObject(DiscardSubsequentRules::class, []);
    }

    /**
     * Test process method
     *
     * @param array $data
     * @param array $result
     * @dataProvider processDataProvider
     */
    public function testProcess($data, $result)
    {
        $this->assertSame($result, $this->processor->process($data));
    }

    /**
     * @return array
     */
    public function processDataProvider()
    {
        return [
            [
                'data' => [],
                'result' => []
            ],
            [
                'data' => [EarnRuleInterface::DISCARD_SUBSEQUENT_RULES => false],
                'result' => [EarnRuleInterface::DISCARD_SUBSEQUENT_RULES => '0']
            ],
            [
                'data' => [EarnRuleInterface::DISCARD_SUBSEQUENT_RULES => true],
                'result' => [EarnRuleInterface::DISCARD_SUBSEQUENT_RULES => '1']
            ],
        ];
    }
}
