<?php

namespace Playhf\InfoBar\Model\InfoBar;

use Playhf\InfoBar\Model\ResourceModel\InfoBar\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;

    protected $dataPersistor;

    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $blockCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $blockCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Magento\Cms\Model\Block $infobar */
        foreach ($items as $infobar) {
            $this->loadedData[$infobar->getId()] = $infobar->getData();
        }

//        $data = $this->dataPersistor->get('cms_block');
//        if (!empty($data)) {
//            $infobar = $this->collection->getNewEmptyItem();
//            $infobar->setData($data);
//            $this->loadedData[$infobar->getId()] = $infobar->getData();
//            $this->dataPersistor->clear('cms_block');
//        }

        return $this->loadedData;
    }
}