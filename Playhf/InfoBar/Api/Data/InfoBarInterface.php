<?php

namespace Playhf\InfoBar\Api\Data;

/**
 * Top information bar Interface
 * @package Playhf\InfoBar\Api\Data
 */
interface InfoBarInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_ID     = 'entity_id';
    const TITLE         = 'title';
    const CONTENT       = 'content';
    const BG_COLOR      = 'bg_color';
    const STORE_ID      = 'store_id';
    const STORES        = 'stores';
    const IS_ACTIVE     = 'is_active';
    const PRIORITY      = 'priority';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent();

    /**
     * Get Background Color
     *
     * @return string|null
     */
    public function getBgColor();

    /**
     * Get Store Id
     *
     * @return int|null
     */
    public function getStores();

    /**
     * Get content
     *
     * @return int|null
     */
    public function getPriority();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Set ID
     *
     * @param int $id
     * @return InfoBarInterface
     */
    public function setId($id);

    /**
     * Set title
     *
     * @param string $title
     * @return InfoBarInterface
     */
    public function setTitle($title);

    /**
     * Set Content
     *
     * @param string $content
     * @return InfoBarInterface
     */
    public function setContent($content);

    /**
     * Set Background Color
     *
     * @param string $bgColor
     * @return InfoBarInterface
     */
    public function setBgColor($bgColor);

    /**
     * Set Store Id
     *
     * @param int $storeId
     * @return InfoBarInterface
     */
    public function setStores($storeId);

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return InfoBarInterface
     */
    public function setIsActive($isActive);

    /**
     * Set Priority
     *
     * @param int $priority
     * @return InfoBarInterface
     */
    public function setPriority($priority);
}