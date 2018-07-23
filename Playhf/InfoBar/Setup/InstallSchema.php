<?php

namespace Playhf\InfoBar\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Playhf\InfoBar\Api\Data\InfoBarInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Table name
     */
    const TABLE_NAME_MAIN   = 'top_information_bar';

    /**
     * Table for stores
     */
    const TABLE_NAME_STORES = 'top_information_bar_stores';

    /**
     * @inheritdoc
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $connection = $setup->getConnection();

        /**
         * Create our cities table
         */
        $table = $connection->newTable(
            $setup->getTable(static::TABLE_NAME_MAIN)
        )->addColumn(
            InfoBarInterface::ENTITY_ID,
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity Id'
        )->addColumn(
            InfoBarInterface::TITLE,
            Table::TYPE_TEXT,
            50,
            ['nullable' => false]
        )->addColumn(
            InfoBarInterface::CONTENT,
            Table::TYPE_TEXT,
            '64k',
            ['nullable' => false]
        )->addColumn(
            InfoBarInterface::BG_COLOR,
            Table::TYPE_TEXT,
            50,
            ['nullable' => false]
        )->addColumn(
            InfoBarInterface::IS_ACTIVE,
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'default' => '1']
        )->addColumn(
            InfoBarInterface::PRIORITY,
            Table::TYPE_INTEGER,
            255,
            ['unsigned' => true, 'nullable' => false]
        )->addIndex(
            $setup->getIdxName(static::TABLE_NAME_MAIN, [InfoBarInterface::IS_ACTIVE]),
            [InfoBarInterface::IS_ACTIVE]
        )->addIndex(
            $setup->getIdxName(
                $setup->getTable(static::TABLE_NAME_MAIN),
                [InfoBarInterface::TITLE, InfoBarInterface::CONTENT],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            [InfoBarInterface::TITLE, InfoBarInterface::CONTENT],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'Top Information Bar Table'
        );

        $connection->createTable($table);

        $table = $connection->newTable(
            $setup->getTable(static::TABLE_NAME_STORES)
        )->addColumn(
            InfoBarInterface::ENTITY_ID,
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity Id'
        )->addColumn(
            InfoBarInterface::STORE_ID,
            Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store Id'
        )->addIndex(
            $setup->getIdxName(static::TABLE_NAME_STORES, ['store_id']),
            ['store_id']
        )->addForeignKey(
            $setup->getFkName(static::TABLE_NAME_STORES, InfoBarInterface::ENTITY_ID, static::TABLE_NAME_MAIN, InfoBarInterface::ENTITY_ID),
            InfoBarInterface::ENTITY_ID,
            $setup->getTable(static::TABLE_NAME_MAIN),
            InfoBarInterface::ENTITY_ID,
            Table::ACTION_CASCADE
        )->addForeignKey(
            $setup->getFkName(static::TABLE_NAME_STORES, InfoBarInterface::STORE_ID, 'store', InfoBarInterface::STORE_ID),
            InfoBarInterface::STORE_ID,
            $setup->getTable('store'),
            InfoBarInterface::STORE_ID,
            Table::ACTION_CASCADE
        )->setComment(
            'Stores for top information bar'
        );

        $connection->createTable($table);

        $setup->endSetup();
    }
}