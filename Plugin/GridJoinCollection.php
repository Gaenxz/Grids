<?php
namespace Magenest\Grids\Plugin;

use Magento\Framework\Message\ManagerInterface as MessageManager;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as SalesOrderGridCollection;
use Magento\Customer\Model\ResourceModel\Grid\Collection as CustomerGridCollection;
use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;

class GridJoinCollection
{
    private $messageManager;

    private $salesorderCollection;

    private $customerCollection;

    public function __construct
    (
        MessageManager $messageManager,
        SalesOrderGridCollection $salesorderCollection,
        CustomerGridCollection $customerCollection
    ) {

        $this->messageManager = $messageManager;
        $this->salesorderCollection = $salesorderCollection;
        $this->customerCollection = $customerCollection;
    }

    public function afterGetReport(
        CollectionFactory $subject,
        $collection,
        $requestName
    ) {
        $result = $requestName;
        if ($requestName == 'sales_order_grid_data_source') {
                $select = $collection->getSelect();
                $select->joinLeft(
                    ["secondTable" => $collection->getTable("magenest_custom_column")],
                    'main_table.increment_id = secondTable.id',
                    array('custom_column')
                );
                return $collection;
        }
        elseif($requestName == 'customer_listing_data_source')
        {
            $select = $collection->getSelect();
            $select->joinLeft(
                ["secondTable" => $collection->getTable("magenest_custom_column")],
                'main_table.entity_id = secondTable.id',
                array('custom_column')
            );
            return $collection;
        }
        return $result;
    }
}