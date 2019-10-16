<?php

namespace Magenest\Grids\Model\Grid;

use Magento\Catalog\Model\Indexer\Category\Product\TableMaintainer;
use Magento\Catalog\Model\Indexer\Product\Price\PriceTableResolver;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Magento\Catalog\Model\ResourceModel\Product\Collection\ProductLimitationFactory;
use Magento\Customer\Api\GroupManagementInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Indexer\DimensionFactory;

class JoinProductCollection extends ProductCollection
{
    public function __construct(\Magento\Framework\Data\Collection\EntityFactory $entityFactory, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Eav\Model\Config $eavConfig, \Magento\Framework\App\ResourceConnection $resource, \Magento\Eav\Model\EntityFactory $eavEntityFactory, \Magento\Catalog\Model\ResourceModel\Helper $resourceHelper, \Magento\Framework\Validator\UniversalFactory $universalFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Module\Manager $moduleManager, \Magento\Catalog\Model\Indexer\Product\Flat\State $catalogProductFlatState, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Catalog\Model\Product\OptionFactory $productOptionFactory, \Magento\Catalog\Model\ResourceModel\Url $catalogUrl, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Stdlib\DateTime $dateTime, GroupManagementInterface $groupManagement, \Magento\Framework\DB\Adapter\AdapterInterface $connection = null, ProductLimitationFactory $productLimitationFactory = null, MetadataPool $metadataPool = null, TableMaintainer $tableMaintainer = null, PriceTableResolver $priceTableResolver = null, DimensionFactory $dimensionFactory = null)
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $eavConfig, $resource, $eavEntityFactory, $resourceHelper, $universalFactory, $storeManager, $moduleManager, $catalogProductFlatState, $scopeConfig, $productOptionFactory, $catalogUrl, $localeDate, $customerSession, $dateTime, $groupManagement, $connection, $productLimitationFactory, $metadataPool, $tableMaintainer, $priceTableResolver, $dimensionFactory);
    }

    public function _initSelect()
    {
        parent::_initSelect();
        $this->addFilterToMap('custom_column','custom_column');
        $this->getSelect()->join(['second_table' => 'magenest_custom_column'],'e.entity_id = second_table.id','second_table.custom_column');
        return $this;
    }
}