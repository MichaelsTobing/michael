<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

namespace Aheadworks\Followupemail2\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Aheadworks\Followupemail2\Model\Serializer;

/**
 * Class UpgradeData
 *
 * @package Aheadworks\Followupemail2\Setup
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param Serializer $serializer
     */
    public function __construct(
        Serializer $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '2.0.2', '<')) {
            $this->convertSerializedDataToJson($setup);
        }
        $setup->endSetup();
    }

    /**
     * Convert metadata from serialized to JSON format if needed
     *
     * @param ModuleDataSetupInterface $setup
     * @return $this
     */
    public function convertSerializedDataToJson($setup)
    {
        $connection = $setup->getConnection();
        $tableName = $setup->getTable('aw_fue2_event');

        $select = $connection->select()->from($tableName);
        $events = $connection->fetchAssoc($select);

        foreach ($events as $event) {
            $toUpdate = [];
            $cartCondUnserialized = $this->unserializeString($event['cart_conditions']);
            if ($cartCondUnserialized !== false && is_array($cartCondUnserialized)) {
                $toUpdate['cart_conditions'] = $this->serializer->serialize($cartCondUnserialized);
            }

            $lifetimeCondUnserialized = $this->unserializeString($event['lifetime_conditions']);
            if ($lifetimeCondUnserialized !== false && is_array($lifetimeCondUnserialized)) {
                $toUpdate['lifetime_conditions'] = $this->serializer->serialize($lifetimeCondUnserialized);
            }

            if (!empty($toUpdate)) {
                $connection->update($tableName, $toUpdate, ['id = ?' => $event['id']]);
            }
        }

        return $this;
    }

    /**
     * Unserialize string with unserialize method
     *
     * @param $string
     * @return array|bool
     */
    private function unserializeString($string)
    {
        $result = @unserialize($string);

        if ($result !== false || $string === 'b:0;') {
            return $result;
        } else {
            return false;
        }
    }
}
