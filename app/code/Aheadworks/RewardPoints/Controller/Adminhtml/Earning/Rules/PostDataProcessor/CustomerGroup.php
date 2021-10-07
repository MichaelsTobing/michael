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
namespace Aheadworks\RewardPoints\Controller\Adminhtml\Earning\Rules\PostDataProcessor;

use Aheadworks\RewardPoints\Api\Data\EarnRuleInterface;
use Aheadworks\RewardPoints\Model\Data\ProcessorInterface;

/**
 * Class CustomerGroup
 * @package Aheadworks\RewardPoints\Controller\Adminhtml\Earning\Rules\PostDataProcessor
 */
class CustomerGroup implements ProcessorInterface
{
    /**
     * {@inheritdoc}
     */
    public function process($data)
    {
        $customerGroupData = [];
        if (isset($data[EarnRuleInterface::CUSTOMER_GROUP_IDS])
            && is_array($data[EarnRuleInterface::CUSTOMER_GROUP_IDS])
        ) {
            foreach ($data[EarnRuleInterface::CUSTOMER_GROUP_IDS] as $key => $value) {
                $customerGroupData[$key] = (int)$value;
            }
        }
        $data[EarnRuleInterface::CUSTOMER_GROUP_IDS] = $customerGroupData;

        return $data;
    }
}
