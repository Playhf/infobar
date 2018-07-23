<?php

namespace Playhf\InfoBar\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Top Information Bar CRUD interface.
 */
interface InfoBarRepositoryInterface
{
    /**
     * Save Information Bar.
     *
     * @param Data\InfoBarInterface $infoBar
     * @return Data\InfoBarInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\InfoBarInterface $infoBar);

    /**
     * Retrieve Information Bar model
     *
     * @return Data\InfoBarInterface
     */
    public function get();

    /**
     * Retrieve Information Bar by id
     *
     * @param int $infoBarId
     * @return Data\InfoBarInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($infoBarId);

    /**
     * Retrieve bars matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return Data\InfoBarSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete information bar.
     *
     * @param Data\InfoBarInterface $infoBar
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\InfoBarInterface $infoBar);

    /**
     * Delete bar by ID.
     *
     * @param int $infoBarId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($infoBarId);
}