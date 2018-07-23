<?php

namespace Playhf\InfoBar\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for top information bars
 * @package Playhf\InfoBar\Api\Data
 */
interface InfoBarSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get pages list.
     *
     * @return \Playhf\InfoBar\Api\Data\InfoBarInterface[]
     */
    public function getItems();

    /**
     * Set pages list.
     *
     * @param \Playhf\InfoBar\Api\Data\InfoBarInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}