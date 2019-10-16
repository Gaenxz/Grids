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

    public function aroundGetReport(
        CollectionFactory $subject,
        \Closure $proceed,
        $requestName
    ) {
        $result = $proceed($requestName);
        if ($requestName == 'sales_order_grid_data_source') {
            if ($result instanceof $this->salesorderCollection
            ) {
                $select = $this->salesorderCollection->getSelect();
                $select->joinLeft(
                    ["secondTable" => $this->salesorderCollection->getTable("magenest_custom_column")],
                    'main_table.increment_id = secondTable.id',
                    array('custom_column')
                );
                return $this->salesorderCollection;
            }
        }
        elseif($requestName == 'customer_listing_data_source')
        {
            if ($result instanceof $this->customerCollection
            ) {
                $select = $this->customerCollection->getSelect();
                $select->joinLeft(
                    ["secondTable" => $this->customerCollection->getTable("magenest_custom_column")],
                    'main_table.entity_id = secondTable.id',
                    array('custom_column')
                );
                return $this->customerCollection;
            }
        }
        return $result;
    }
}