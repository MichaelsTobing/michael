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
 * @package    AdvancedReports
 * @version    2.8.5
 * @copyright  Copyright (c) 2020 Aheadworks Inc. (http://www.aheadworks.com)
 * @license    https://ecommerce.aheadworks.com/end-user-license-agreement/
 */
namespace Aheadworks\AdvancedReports\Model\Filter\Dashboard;

use Aheadworks\AdvancedReports\Model\Source\Groupby as GroupbySource;

/**
 * Class GroupBy
 *
 * @package Aheadworks\AdvancedReports\Model\Filter\Dashboard
 */
class GroupBy extends \Aheadworks\AdvancedReports\Model\Filter\GroupBy
{
    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return GroupbySource::TYPE_DAY;
    }
}
