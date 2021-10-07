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

use Aheadworks\RewardPoints\Ui\DataProvider\EarnRule\DataProcessor\Action;
use Aheadworks\RewardPoints\Api\Data\EarnRuleInterface;
use Aheadworks\RewardPoints\Model\Action as RuleAction;
use Magento\Framework\Api\AttributeInterface;
use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\RewardPoints\Ui\DataProvider\EarnRule\DataProcessor\Action
 */
class ActionTest extends TestCase
{
    /**
     * @var Action
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

        $this->processor = $objectManager->getObject(Action::class, []);
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
        $this->assertEquals($result, $this->processor->process($data));
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
                'data' => [
                    EarnRuleInterface::ACTION => [
                        RuleAction::TYPE => 'sample_type'
                    ]
                ],
                'result' => [
                    EarnRuleInterface::ACTION => [
                        RuleAction::TYPE => 'sample_type'
                    ]
                ]
            ],
            [
                'data' => [
                    EarnRuleInterface::ACTION => [
                        RuleAction::TYPE => 'sample_type',
                        RuleAction::ATTRIBUTES => [
                            [
                                AttributeInterface::ATTRIBUTE_CODE => 'attribute_one',
                                AttributeInterface::VALUE => 123
                            ],
                            [
                                AttributeInterface::ATTRIBUTE_CODE => 'attribute_two',
                                AttributeInterface::VALUE => 'Sample Text'
                            ]
                        ],
                    ]
                ],
                'result' => [
                    EarnRuleInterface::ACTION => [
                        RuleAction::TYPE => 'sample_type',
                        'attribute_one' => '123',
                        'attribute_two' => 'Sample Text'
                    ]
                ]
            ],
            [
                'data' => [
                    EarnRuleInterface::ACTION => [
                        RuleAction::TYPE => 'sample_type',
                        RuleAction::ATTRIBUTES => [],
                    ]
                ],
                'result' => [
                    EarnRuleInterface::ACTION => [
                        RuleAction::TYPE => 'sample_type',
                    ]
                ]
            ],
        ];
    }
}
