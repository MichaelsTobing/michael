<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Followupemail2\Test\Unit\Block\Adminhtml\Campaign;

use Aheadworks\Followupemail2\Block\Adminhtml\Campaign\SaveButton;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

/**
 * Test for \Aheadworks\Followupemail2\Block\Adminhtml\Campaign\SaveButton
 */
class SaveButtonTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var SaveButton
     */
    private $button;

    /**
     * Init mocks for tests
     *
     * @return void
     */
    public function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->button = $objectManager->getObject(
            SaveButton::class,
            []
        );
    }

    /**
     * Test getButtonData method
     */
    public function testGetButtonData()
    {
        $this->assertTrue(is_array($this->button->getButtonData()));
    }
}
