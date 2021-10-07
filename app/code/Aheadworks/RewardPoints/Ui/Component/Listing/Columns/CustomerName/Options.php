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
namespace Aheadworks\RewardPoints\Ui\Component\Listing\Columns\CustomerName;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class Aheadworks\RewardPoints\Ui\Component\Listing\Columns\CustomerName\Options
 */
class Options implements OptionSourceInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

     /**
      *  {@inheritDoc}
      */
    public function toOptionArray()
    {
        $customersOptions = [];
        /** @var CustomerInterface[] $customers */
        $customers = $this->customerRepository->getList($this->searchCriteriaBuilder->create());
        foreach ($customers->getItems() as $customer) {
            if ($customer->getId() == 0) {
                continue;
            }
            $customersOptions[] = [
                'label' => $this->compileCustomerName($customer),
                'value' => $customer->getId(),
            ];
        }

        return $customersOptions;
    }

    /**
     * Compile customer name from firstname and lastname
     *
     * @param CustomerInterface $customer
     * @return string
     */
    private function compileCustomerName(CustomerInterface $customer)
    {
        return $customer->getFirstname() . ' ' . $customer->getLastname();
    }
}
