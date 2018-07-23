<?php

namespace Playhf\InfoBar\Model;

use Playhf\InfoBar\Api\Data\InfoBarInterface;
use Magento\Framework\Model\AbstractModel;

class InfoBar extends AbstractModel implements InfoBarInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\InfoBar::class);
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @inheritdoc
     */
    public function getStores()
    {
        return $this->getData(self::STORES);
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return $this->getData(self::PRIORITY);
    }

    /**
     * {@inheritdoc}
     */
    public function getBgColor()
    {
        return $this->getData(self::BG_COLOR);
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * {@inheritdoc}
     */
    public function setStores($storeId)
    {
        return $this->setData(self::STORES, $storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * {@inheritdoc}
     */
    public function setPriority($priority)
    {
        return $this->setData(self::PRIORITY, $priority);
    }

    /**
     * {@inheritdoc}
     */
    public function setBgColor($bgColor)
    {
        return $this->setData(self::BG_COLOR, $bgColor);
    }

    /**
     * {@inheritdoc}
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }
}