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
namespace Aheadworks\AdvancedReports\Model\ResourceModel\Indexer\Statistics;

/**
 * Class PaymentType
 *
 * @package Aheadworks\AdvancedReports\Model\ResourceModel\Indexer\Statistics
 */
class PaymentType extends AbstractResource
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('aw_arep_payment_type', 'id');
    }

    /**
     * {@inheritdoc}
     */
    protected function process()
    {
        $period = $this->getPeriod('main_table.created_at');
        $columns = [
            'period' => $period,
            'store_id' => 'main_table.store_id',
            'order_status' => 'main_table.status',
            'customer_group_id' => 'main_table.customer_group_id',
            'method' => 'order_payment.method',
            'additional_info' => 'order_payment.additional_information',
            'orders_count' => 'COUNT(main_table.entity_id)',
            'order_items_count' => 'SUM(COALESCE(main_table.total_qty_ordered, 0))',
            'subtotal' => 'SUM(COALESCE(main_table.base_subtotal, 0.0))',
            'tax' => 'SUM(COALESCE(main_table.base_tax_amount, 0.0))',
            'shipping' => 'SUM(COALESCE(main_table.base_shipping_amount, 0.0))',
            'discount' => 'ABS(SUM(COALESCE(main_table.base_discount_amount, 0.0)))',
            'other_discount' => $this->getOtherDiscountsExpression(),
            'total' => 'SUM(COALESCE(main_table.base_subtotal, 0.0) 
                        + COALESCE(main_table.base_discount_amount, 0.0) 
                        + COALESCE(main_table.base_discount_tax_compensation_amount, 0.0) 
                        + COALESCE(main_table.base_tax_amount, 0.0) 
                        + COALESCE(main_table.base_shipping_amount, 0.0))',
            'invoiced' => 'SUM(COALESCE(main_table.base_total_invoiced, 0.0))',
            'refunded' => 'SUM(COALESCE(main_table.base_total_refunded, 0.0))',
            'to_global_rate' => 'main_table.base_to_global_rate'
        ];

        $select = $this->getConnection()->select()
            ->from(['main_table' => $this->getTable('sales_order')], [])
            ->join(
                ['order_payment' => $this->getTable('sales_order_payment')],
                'order_payment.parent_id = main_table.entity_id',
                []
            )
            ->columns($columns)
            ->group(
                [
                    'main_table.status',
                    $period,
                    'main_table.store_id',
                    'order_payment.method',
                    'main_table.base_to_global_rate',
                    'main_table.customer_group_id'
                ]
            );
        $select = $this->addFilterByCreatedAt($select, 'main_table');

        $this->safeInsertFromSelect($select, $this->getIdxTable(), array_keys($columns));
    }
}
