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
namespace Aheadworks\RewardPoints\Model\ResourceModel\Transaction\Relation\PointsSummary;

use Aheadworks\RewardPoints\Model\Service\PointsSummaryService;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Class Aheadworks\RewardPoints\Model\ResourceModel\Transaction\Relation\PointsSummary\SaveHandler
 */
class SaveHandler implements ExtensionInterface
{
    /**
     * @var PointsSummaryService
     */
    private $pointsSummaryService;

    /**
     * @param PointsSummaryService $pointsSummaryService
     */
    public function __construct(
        PointsSummaryService $pointsSummaryService
    ) {
        $this->pointsSummaryService = $pointsSummaryService;
    }

    /**
     *  {@inheritDoc}
     */
    public function execute($entity, $arguments = [])
    {
        $this->pointsSummaryService->addPointsSummaryToCustomer($entity);
        return $entity;
    }
}
