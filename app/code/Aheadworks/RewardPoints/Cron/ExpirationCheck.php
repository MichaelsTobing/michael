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
namespace Aheadworks\RewardPoints\Cron;

use Aheadworks\RewardPoints\Api\CustomerRewardPointsManagementInterface;
use Aheadworks\RewardPoints\Model\Source\Transaction\Status;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Aheadworks\RewardPoints\Model\TransactionRepository;
use Aheadworks\RewardPoints\Api\Data\TransactionInterface;
use Aheadworks\RewardPoints\Model\Flag;

/**
 * Class Aheadworks\RewardPoints\Cron\ExpirationCheck
 */
class ExpirationCheck extends CronAbstract
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if ($this->isLocked(Flag::AW_RP_EXPIRATION_CHECK_LAST_EXEC_TIME)) {
            return $this;
        }
        $this->createExpiredTransactions();
        $this->setFlagData(Flag::AW_RP_EXPIRATION_CHECK_LAST_EXEC_TIME);
    }

    /**
     * Create expired transactions
     *
     * @return $this
     */
    private function createExpiredTransactions()
    {
        $this->searchCriteriaBuilder
            ->addFilter(TransactionInterface::STATUS, Status::ACTIVE)
            ->addFilter(TransactionInterface::EXPIRATION_DATE, 'expired');

        $expiredTransactions = $this->transactionRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        foreach ($expiredTransactions as $expiredTransaction) {
            $this->customerRewardPointsService->expiredTransactionPoints(
                $expiredTransaction->getCustomerId(),
                $expiredTransaction->getBalance() + $expiredTransaction->getBalanceAdjusted(),
                $expiredTransaction->getWebsiteId(),
                $expiredTransaction->getTransactionId()
            );
        }
        return $this;
    }
}
