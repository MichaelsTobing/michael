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
namespace Aheadworks\RewardPoints\Model\EarnRule;

use Aheadworks\RewardPoints\Api\Data\EarnRuleInterface;
use Aheadworks\RewardPoints\Api\EarnRuleRepositoryInterface;
use Aheadworks\RewardPoints\Model\Config;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface as Logger;

/**
 * Class CategoryPromoTextResolver
 * @package Aheadworks\RewardPoints\Model\EarnRule
 */
class CategoryPromoTextResolver
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var EarnRuleRepositoryInterface
     */
    private $earnRuleRepository;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Config $config
     * @param EarnRuleRepositoryInterface $earnRuleRepository
     * @param Logger $logger
     */
    public function __construct(
        Config $config,
        EarnRuleRepositoryInterface $earnRuleRepository,
        Logger $logger
    ) {
        $this->config = $config;
        $this->earnRuleRepository = $earnRuleRepository;
        $this->logger = $logger;
    }

    /**
     * Get category product promo text
     *
     * @param int[] $appliedRuleIds
     * @param int|null $storeId
     * @return string
     */
    public function getPromoText($appliedRuleIds, $storeId = null)
    {
        $promoText = '';
        $appliedRulesCount = count($appliedRuleIds);
        switch (true) {
            case $appliedRulesCount == 1:
                $ruleId = reset($appliedRuleIds);
                try {
                    /** @var EarnRuleInterface $rule */
                    $rule = $this->earnRuleRepository->get($ruleId, $storeId);
                    $promoText = $rule->getCurrentLabels()->getCategoryPromoText();
                } catch (NoSuchEntityException $exception) {
                    $this->logger->critical($exception->getMessage());
                }
                break;

            case $appliedRulesCount > 1:
                $promoText = $this->config->getCategoryProductPromoText($storeId)
                    ? $this->config->getCategoryProductPromoText($storeId)
                    : '';
                break;
        }

        return $promoText;
    }
}
