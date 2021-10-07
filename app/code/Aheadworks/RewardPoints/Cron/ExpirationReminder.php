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
use Aheadworks\RewardPoints\Model\Source\NotifiedStatus;
use Aheadworks\RewardPoints\Model\Source\Transaction\Status;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Aheadworks\RewardPoints\Model\TransactionRepository;
use Aheadworks\RewardPoints\Api\Data\TransactionInterface;
use Aheadworks\RewardPoints\Model\Flag;

/**
 * Class Aheadworks\RewardPoints\Cron\ExpirationReminder
 */
class ExpirationReminder extends CronAbstract
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if ($this->isLocked(Flag::AW_RP_EXPIRATION_REMINDER_LAST_EXEC_TIME)) {
            return $this;
        }
        $this->sendExpiredReminder();
        $this->setFlagData(Flag::AW_RP_EXPIRATION_REMINDER_LAST_EXEC_TIME);
    }

    /**
     * Send expired reminder
     *
     * @return $this
     */
    private function sendExpiredReminder()
    {
        $this->searchCriteriaBuilder
            ->addFilter(TransactionInterface::STATUS, Status::ACTIVE)
            ->addFilter(TransactionInterface::EXPIRATION_NOTIFIED, NotifiedStatus::WAITING)
            ->addFilter(TransactionInterface::STATUS, Status::ACTIVE)
            ->addFilter(TransactionInterface::EXPIRATION_DATE, 'will_expire');

        $willExpireTransactions = $this->transactionRepository
            ->getList($this->searchCriteriaBuilder->create())
            ->getItems();

        $customersData = [];
        foreach ($willExpireTransactions as $willExpireTransaction) {
            $customerId = $willExpireTransaction->getCustomerId();
            if (!isset($customersData[$customerId])) {
                $customersData[$customerId] = [
                    'store_id' => null,
                    'comment' => null,
                    'balance' => $willExpireTransaction->getBalance() + $willExpireTransaction->getBalanceAdjusted(),
                    'expiration_date' => $willExpireTransaction->getExpirationDate(),
                    'notified_status' => NotifiedStatus::NO
                ];
            } else {
                $customersData[$customerId]['balance'] +=
                    $willExpireTransaction->getBalance() + $willExpireTransaction->getBalanceAdjusted();
            }
        }

        foreach ($customersData as $customerId => $customerData) {
            $customersData[$customerId]['notified_status'] = $this->customerRewardPointsService->sendNotification(
                $customerId,
                TransactionInterface::EXPIRATION_NOTIFIED,
                $customerData
            );
        }

        foreach ($willExpireTransactions as $willExpireTransaction) {
            $customerId = $willExpireTransaction->getCustomerId();
            $willExpireTransaction->setExpirationNotified($customersData[$customerId]['notified_status']);
            $this->transactionRepository->save($willExpireTransaction);
        }
        return $this;
    }
}
