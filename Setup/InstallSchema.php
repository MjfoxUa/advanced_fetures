<?php

namespace Mjfox\Education\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('mjfox_education')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mjfox_education')
            )
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'ID'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Name'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_INTEGER,
                    255,
                    [
                        'nullable'  => false
                    ],
                    'Status'
                )
                ->addColumn(
                    'attach_image',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable' => true,
                        'comment' => 'Attached images',
                    ]
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Description'
                )
                ->setComment('Education Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('mjfox_education'),
                $setup->getIdxName(
                    $installer->getTable('mjfox_education'),
                    ['name'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }
}

