<?php
namespace Magenest\Grids\Plugin;

use Magento\Framework\Message\ManagerInterface as MessageManager;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as SalesOrderGridCollection;
use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;

class OrderGridJoinCollection
{
    private $messageManager;
    private $collection;

    public function __construct
    (
        MessageManager $messageManager,
        SalesOrderGridCollection $collection
    ) {

        $this->messageManager = $messageManager;
        $this->collection = $collection;
    }

    public function aroundGetReport(
        CollectionFactory $subject,
        \Closure $proceed,
        $requestName
    ) {
        $result = $proceed($requestName);
        if ($requestName == 'sales_order_grid_data_source') {
            if ($result instanceof $this->collection
            ) {
                $select = $this->collection->getSelect();
                $select->joinLeft(
                    ["secondTable" => $this->collection->getTable("magenest_custom_column")],
                    'main_table.increment_id = secondTable.id',
                    array('custom_column')
                );
                return $this->collection;
            }
        }
        return $result;
    }
}