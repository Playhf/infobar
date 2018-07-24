<?php

namespace Playhf\InfoBar\Model;

use Playhf\InfoBar\Api\Data;
use Playhf\InfoBar\Api\InfoBarRepositoryInterface;
use Playhf\InfoBar\Model\ResourceModel\InfoBar as Resource;
use Playhf\InfoBar\Model\ResourceModel\InfoBar\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;


/**
 * Class InfoBarRepository
 * @package Playhf\InfoBar\Model
 */
class InfoBarRepository implements InfoBarRepositoryInterface
{
    /**
     * @var \Playhf\InfoBar\Model\ResourceModel\InfoBar
     */
    protected $resource;

    /**
     * @var Data\InfoBarInterfaceFactory
     */
    protected $infoBarFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var Data\InfoBarSearchResultInterfaceFactory
     */
    protected $searchResultFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * InfoBarRepository constructor.
     * @param Resource $resource
     * @param CollectionFactory $collectionFactory
     * @param Data\InfoBarInterfaceFactory $infoBarFactory
     * @param Data\InfoBarSearchResultInterfaceFactory $searchResultFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface|null $collectionProcessor
     */
    public function __construct(
        Resource $resource,
        CollectionFactory $collectionFactory,
        Data\InfoBarInterfaceFactory $infoBarFactory,
        Data\InfoBarSearchResultInterfaceFactory $searchResultFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->resource = $resource;
        $this->infoBarFactory = $infoBarFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultFactory = $searchResultFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->collectionProcessor = $collectionProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * @param Data\InfoBarInterface $infoBar
     * @return Data\InfoBarInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\InfoBarInterface $infoBar)
    {
        try {
            $this->resource
                ->save($infoBar)
                ->saveStores($infoBar);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the information bar: %1', $exception->getMessage()),
                $exception
            );
        }
        return $infoBar;
    }

    /**
     * Load Info Bar data collection by given search criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return Data\InfoBarSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Playhf\InfoBar\Model\ResourceModel\InfoBar\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var Data\InfoBarSearchResultInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @inheritdoc
     */
    public function get()
    {
        return $this->infoBarFactory->create();
    }

    /**
     * @param string $infoBarId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($infoBarId)
    {
        $infoBar = $this->infoBarFactory->create();
        $infoBar->load($infoBarId);

        if (!$infoBar->getId()) {
            throw new NoSuchEntityException(__('Information Bar with id "%1" does not exist.', $infoBarId));
        }

        return $infoBar;
    }

    /**
     * Delete Information Bar
     *
     * @param Data\InfoBarInterface $infoBar
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\InfoBarInterface $infoBar)
    {
        try {
            $this->resource->delete($infoBar);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the information bar: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete information bar by given identifier
     *
     * @param string $infoBarId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($infoBarId)
    {
        return $this->delete($this->getById($infoBarId));
    }

    protected function getCollectionProcessor()
    {

    }
}