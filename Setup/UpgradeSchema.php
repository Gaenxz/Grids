<?php

namespace Magenest\Grids\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            $installer = $setup;
            $installer->startSetup();
            if (!$installer->tableExists('magenest_custom_column')) {
                $table = $installer->getConnection()->newTable(
                    $installer->getTable('magenest_custom_column')
                )
                    ->addColumn(
                        'id',
                        Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'nullable' => false,
                            'primary' => true,
                            'unsigned' => true,
                        ],
                        'Increment ID'
                    )
                    ->addColumn(
                        'custom_column',
                        Table::TYPE_TEXT,
                        100,
                        ['nullable => false'],
                        'Custom Column'
                    )
                    ->setComment('Custom Column Table');
                $installer->getConnection()->createTable($table);
            }
        }
    }
}