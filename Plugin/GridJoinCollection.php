<?php
namespace Magenest\Grids\Plugin;

use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;

class GridJoinCollection
{
    public function afterGetReport(
        CollectionFactory $subject,
        $collection,
        $requestName
    ) {
        switch ($requestName)
        {
            case 'sales_order_grid_data_source' :
                $mainID = 'increment_id';
                return $collection = $this->joinTable( $collection, $mainID);
                break;
            case 'customer_listing_data_source' :
                $mainID = 'entity_id';
                return $collection = $this->joinTable( $collection, $mainID);
                break;
            default : return $collection;
        }
    }

    private function joinTable($collection, $mainID)
    {
        $select = $collection->getSelect();
        $select->joinLeft(
            ["secondTable" => $collection->getTable("magenest_custom_column")],
            'main_table.' . $mainID . ' = secondTable.id',
            array('custom_column')
        );
        return $collection;
    }
}