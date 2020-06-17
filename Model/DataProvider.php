<?php

namespace Mjfox\Education\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Mjfox\Education\Model\ResourceModel\Education\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    private $loadedData = [];

    /**
     * Data Provider constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $employeeCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $educationCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $educationCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $items = $this->collection->getItems();

        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
        }

        return $this->loadedData;
    }
}
