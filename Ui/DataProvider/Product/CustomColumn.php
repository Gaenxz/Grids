<?php

namespace Magenest\Grids\Ui\DataProvider\Product;

class CustomColumn implements \Magento\Ui\DataProvider\AddFieldToCollectionInterface
{
    public function addField(\Magento\Framework\Data\Collection $collection, $field, $alias = null){
        $collection->joinField(
            'custom_column',
            'magenest_custom_column',
            'custom_column',
            'increment_id=id',
            null,
            'inner'
        );
    }
}