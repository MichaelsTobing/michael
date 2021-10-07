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
namespace Aheadworks\RewardPoints\Plugin\Magento\Framework\View\Layout\ScheduledStructure;

/**
 * Class HelperPlugin
 *
 * @package Aheadworks\RewardPoints\Plugin\Magento\Framework\View\Layout\ScheduledStructure
 */
class HelperPlugin
{
    /**
     * Rename containers with duplicate name - "customer.form.newsletter.extra"
     *
     * @param \Magento\Framework\View\Layout\ScheduledStructure\Helper $subject
     * @param \Closure $proceed
     * @param \Magento\Framework\View\Layout\ScheduledStructure $scheduledStructure
     * @param \Magento\Framework\View\Layout\Element $currentNode
     * @param \Magento\Framework\View\Layout\Element $parentNode
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundScheduleStructure(
        $subject,
        $proceed,
        $scheduledStructure,
        $currentNode,
        $parentNode
    ) {
        $renameDuplicate = 'customer.form.newsletter.extra';
        if ($currentNode->getAttribute('name') == $renameDuplicate) {
            if ($scheduledStructure->hasStructureElement($renameDuplicate)) {
                $currentNode->setAttribute('name', '');
            }
        }
        return $proceed($scheduledStructure, $currentNode, $parentNode);
    }
}
