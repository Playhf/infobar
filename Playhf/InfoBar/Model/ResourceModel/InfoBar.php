<?php

namespace Playhf\InfoBar\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Playhf\InfoBar\Api\Data\InfoBarInterface;
use Playhf\InfoBar\Setup\InstallSchema;

class InfoBar extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            InstallSchema::TABLE_NAME_MAIN,
            InfoBarInterface::ENTITY_ID
        );
    }

    /**
     * @param $infobarId
     * @return array
     */
    public function lookupStoreIds($infobarId)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable(InstallSchema::TABLE_NAME_STORES),
            InfoBarInterface::STORE_ID
        )->where(
            'entity_id = ?',
            (int)$infobarId
        );

        return $connection->fetchCol($select);
    }

    /**
     * @param AbstractModel $infobar
     * @return $this
     */
    public function saveStores(AbstractModel $infobar)
    {
        $oldStores = $this->lookupStoreIds($infobar->getId());
        $newStores = (array)$infobar->getStores();
        if (empty($newStores)) {
            $newStores = (array)$infobar->getStoreId();
        }
        $table = $this->getTable(InstallSchema::TABLE_NAME_STORES);
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = ['entity_id = ?' => (int)$infobar->getId(), 'store_id IN (?)' => $delete];

            $this->getConnection()->delete($table, $where);
        }

        if ($insert) {
            $data = [];

            foreach ($insert as $storeId) {
                $data[] = ['entity_id' => (int)$infobar->getId(), 'store_id' => (int)$storeId];
            }

            $this->getConnection()->insertMultiple($table, $data);
        }

        return $this;
    }

    /**
     * @param AbstractModel $object
     * @return $this
     */
    protected function _afterLoad(AbstractModel $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('stores', $stores);
        }

        return parent::_afterLoad($object);
    }
}