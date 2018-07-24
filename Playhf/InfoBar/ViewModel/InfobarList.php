<?php

namespace Playhf\InfoBar\ViewModel;


use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManager;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Playhf\InfoBar\Model\InfoBarRepository;
use Playhf\InfoBar\Api\Data\InfoBarInterface;

class InfobarList implements ArgumentInterface
{
    /**
     * @var InfoBarRepository
     */
    private $infobarRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var FilterGroupBuilder
     */
    private $filterGroupBuilder;

    /** @var  SortOrderBuilder */
    private $sortOrderBuilder;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        InfoBarRepository $infoBarRepository,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        SortOrderBuilder $sortOrderBuilder,
        StoreManagerInterface $storeManager
//        StoreManager
    )
    {
        $this->storeManager = $storeManager;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->infobarRepository = $infoBarRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return InfoBarInterface[]
     */
    private function getItems()
    {
        $filter1 = $this->filterBuilder->setField('is_active')
            ->setConditionType('eq')
            ->setValue(1)
            ->create();

        $filter1 = $filterOr = $this->filterGroupBuilder
            ->addFilter($filter1)
            ->create();


        $filterStore1 = $this->filterBuilder->setField('store_id')
            ->setConditionType('eq')
            ->setValue(0)
            ->create();

        $filterStore2 = $this->filterBuilder->setField('store_id')
            ->setConditionType('eq')
            ->setValue($this->storeManager->getStore()->getId())
            ->create();

        $filterOr = $this->filterGroupBuilder
            ->addFilter($filterStore1)
            ->addFilter($filterStore2)
            ->create();

        $sortOrder = $this->sortOrderBuilder->setField('priority')
            ->setDirection('ASC')
            ->create();

        $this->searchCriteriaBuilder->setFilterGroups([$filter1, $filterOr])
            ->addSortOrder($sortOrder);

        $searchCriteria = $this->searchCriteriaBuilder->create();

        $infobarItems = $this->infobarRepository->getList($searchCriteria);

        return $infobarItems->getItems();
    }

    /**
     * @return string
     */
    public function getItemsJson()
    {
        $result = [];
        foreach ($this->getItems() as $infobar) {
            $result[$infobar->getTitle()] = [
                'bg_color'  => $infobar->getBgColor(),
                'content'   => $infobar->getContent()
            ];
        }

        return json_encode($result);
    }
}