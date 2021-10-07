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
 * @package    SocialLogin
 * @version    1.6.3
 * @copyright  Copyright (c) 2020 Aheadworks Inc. (http://www.aheadworks.com)
 * @license    https://ecommerce.aheadworks.com/end-user-license-agreement/
 */
namespace Aheadworks\SocialLogin\Model;

use Aheadworks\SocialLogin\Api\AccountSearchInterface;
use Aheadworks\SocialLogin\Api\Data\AccountInterface;
use Aheadworks\SocialLogin\Model\ResourceModel\Account\Collection;
use Aheadworks\SocialLogin\Model\ResourceModel\Account\CollectionFactory as AccountCollectionFactory;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Model\Config\Share as ShareConfig;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class AccountSearch.
 */
class AccountSearch implements AccountSearchInterface
{
    /**
     * @var AccountCollectionFactory
     */
    private $accountCollectionFactory;

    /**
     * @var ShareConfig
     */
    private $shareConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param AccountCollectionFactory $accountCollectionFactory
     * @param ShareConfig $shareConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        AccountCollectionFactory $accountCollectionFactory,
        ShareConfig $shareConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->accountCollectionFactory = $accountCollectionFactory;
        $this->shareConfig = $shareConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getBySocialId($type, $socialId, $websiteId = null)
    {
        /** @var Collection $accountCollection */
        $accountCollection = $this->accountCollectionFactory->create();
        $accountCollection->addFieldToFilter(AccountInterface::TYPE, $type)
            ->addFieldToFilter(AccountInterface::SOCIAL_ID, $socialId)
            ->join(
                ['cs' => $accountCollection->getTable('customer_entity')],
                'main_table.customer_id = cs.entity_id',
                ['website_id']
            );

        if ($this->shareConfig->isWebsiteScope()) {
            $websiteId = $websiteId ?: $this->storeManager->getWebsite()->getId();
            $accountCollection->addFieldToFilter(CustomerInterface::WEBSITE_ID, $websiteId);
        }

        /** @var AccountInterface $account */
        $account = $accountCollection->getFirstItem();

        if (!$account->getId()) {
            throw new NoSuchEntityException(__('Account with social_id "%1" does not exist.', $socialId));
        }

        return $account;
    }
}
