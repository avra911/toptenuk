<?php
/******************************************************
 * @package MT Slideshow module for Magento 1.4.x.x, Magento 1.5.x.x and Magento 1.6.x.x
 * @version 2.0.0
 * @author http://www.magentheme.com
 * @copyright (C) 2011- MagenTheme.Com
 * @license PHP files are GNU/GPL
*******************************************************/
?>
<?php
class MagenThemes_Mtslideshow_Model_Mysql4_Mtslideshow extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('mtslideshow/mtslideshow', 'slide_id');
    }
    
    protected function _afterLoad(Mage_Core_Model_Abstract $object) {
        if (!$object->getIsMassDelete()) {
            $object = $this->__loadStore($object);
            $object = $this->__loadImage($object);
            $object = $this->__loadCategories($object);
            $object = $this->__loadPages($object);            
        }

        return parent::_afterLoad($object);
    }
    
    protected function _afterSave(Mage_Core_Model_Abstract $object) {
        if (!$object->getIsMassStatus()) {
            $this->__saveToStoreTable($object);
            $this->__saveToImageTable($object);
            $this->__saveToCategoryTable($object);
            $this->__saveToPageTable($object);
        }

        return parent::_afterSave($object);
    }
    
    protected function _beforeDelete(Mage_Core_Model_Abstract $object) {
        $adapter = $this->_getReadAdapter();
        $adapter->delete($this->getTable('mtslideshow/store'), 'slide_id='.$object->getId());
        $adapter->delete($this->getTable('mtslideshow/image'), 'slide_id='.$object->getId());
        $adapter->delete($this->getTable('mtslideshow/category'), 'slide_id='.$object->getId());
        $adapter->delete($this->getTable('mtslideshow/page'), 'slide_id='.$object->getId());

        return parent::_beforeDelete($object);
    }
    
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $select->join(array('cbs' => $this->getTable('mtslideshow/store')), $this->getMainTable().'.slide_id = cbs.slide_id')
                    ->where('cbs.store_id in (0, ?) ', $object->getStoreId())
                    ->order('store_id DESC')
                    ->limit(1);
        }
        return $select;
    }
    
    private function __loadStore(Mage_Core_Model_Abstract $object) {
        $select = $this->_getReadAdapter()->select()
                ->from($this->getTable('mtslideshow/store'))
                ->where('slide_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $array = array();
            foreach ($data as $row) {
                $array[] = $row['store_id'];
            }
            $object->setData('stores', $array);
        }
        return $object;
    }
    
    private function __loadImage(Mage_Core_Model_Abstract $object) {
        $select = $this->_getReadAdapter()->select()
                ->from($this->getTable('mtslideshow/image'))
                ->where('slide_id = ?', $object->getId())
                ->where('disabled = 0', $object->getId())
                ->order(array('order ASC', 'image_id'));

        $object->setData('images', $this->_getReadAdapter()->fetchAll($select));
        return $object;
    }
    
    private function __loadCategories(Mage_Core_Model_Abstract $object) {
        $select = $this->_getReadAdapter()->select()
                ->from($this->getTable('mtslideshow/category'))
                ->where('slide_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $array = array();
            foreach ($data as $row) {
                $array[] = $row['category_id'];
            }
            $object->setData('categories', $array);
        }
        return $object;
    }
    
    private function __loadPages(Mage_Core_Model_Abstract $object) {
        $select = $this->_getReadAdapter()->select()
                ->from($this->getTable('mtslideshow/page'))
                ->where('slide_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $array = array();
            foreach ($data as $row) {
                $array[] = $row['page_id'];
            }
            $object->setData('pages', $array);
        }
        return $object;
    }
    
    private function __saveToStoreTable(Mage_Core_Model_Abstract $object) {
        if (!$object->getData('stores')) {
            $condition = $this->_getWriteAdapter()->quoteInto('slide_id = ?', $object->getId());
            $this->_getWriteAdapter()->delete($this->getTable('mtslideshow/store'), $condition);

            $storeArray = array(
                'slide_id' => $object->getId(),
                'store_id' => '0');
            $this->_getWriteAdapter()->insert($this->getTable('mtslideshow/store'), $storeArray);
            return true;
        }

        $condition = $this->_getWriteAdapter()->quoteInto('slide_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('mtslideshow/store'), $condition);
        foreach ((array)$object->getData('stores') as $store) {
            $storeArray = array();
            $storeArray['slide_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert($this->getTable('mtslideshow/store'), $storeArray);
        }
    }
    
    private function __saveToImageTable(Mage_Core_Model_Abstract $object) {
        if ($_imageList = $object->getData('images')) {
            $_imageList = Zend_Json::decode($_imageList);
            if (is_array($_imageList) and sizeof($_imageList) > 0) {
                $_imageTable = $this->getTable('mtslideshow/image');
                $_adapter = $this->_getWriteAdapter();
                $_adapter->beginTransaction();
                try {
                    $condition = $this->_getWriteAdapter()->quoteInto('slide_id = ?', $object->getId());
                    $this->_getWriteAdapter()->delete($this->getTable('mtslideshow/image'), $condition);

                    foreach ($_imageList as &$_item) {
                        if (isset($_item['removed']) and $_item['removed'] == '1') {
                            $_adapter->delete($_imageTable, $_adapter->quoteInto('image_id = ?', $_item['value_id'], 'INTEGER'));
                        } else {
                            $_data = array(
                                'link'              => $_item['link'],                                
                                'title'             => $_item['title'],
                                'description'       => $_item['description'],
                                'file'              => $_item['file'],
                                'order'          => $_item['order'],
                                'disabled'          => $_item['disabled'],
                                'slide_id'          => $object->getId(),
                                'title_animate'     => $_item['title_animate'],
                                'file_animate'      => $_item['file_animate'],
                                'desc_animate'      => $_item['desc_animate'],
                                'link_animate'      => $_item['link_animate']
                            );
                            $_adapter->insert($_imageTable, $_data);
                        }
                    }
                    $_adapter->commit();
                } catch (Exception $e) {
                    $_adapter->rollBack();
                    echo $e->getMessage();
                }
            }
        }
    }
    
    private function __saveToCategoryTable(Mage_Core_Model_Abstract $object) {
        if (!$object->getData('categories')) {
            $condition = $this->_getWriteAdapter()->quoteInto('slide_id = ?', $object->getId());
            $this->_getWriteAdapter()->delete($this->getTable('mtslideshow/category'), $condition);
            return true;
        }

        $condition = $this->_getWriteAdapter()->quoteInto('slide_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('mtslideshow/category'), $condition);
        foreach ((array)$object->getData('categories') as $categoryId) {
            if($categoryId) {
                $categoryArray = array();
                $categoryArray['slide_id'] = $object->getId();
                $categoryArray['category_id'] = $categoryId;
                $this->_getWriteAdapter()->insert($this->getTable('mtslideshow/category'), $categoryArray);
            }
        }
    }
    
    private function __saveToPageTable(Mage_Core_Model_Abstract $object) {
        if (!$object->getData('pages')) {
            $condition = $this->_getWriteAdapter()->quoteInto('slide_id = ?', $object->getId());
            $this->_getWriteAdapter()->delete($this->getTable('mtslideshow/page'), $condition);
            return true;
        }

        $condition = $this->_getWriteAdapter()->quoteInto('slide_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('mtslideshow/page'), $condition);
        if(in_array('', $object->getData('pages')))
            return true;
        foreach ((array)$object->getData('pages') as $pageId) {
            $pageArray = array();
            $pageArray['slide_id'] = $object->getId();
            $pageArray['page_id'] = $pageId;
            $this->_getWriteAdapter()->insert($this->getTable('mtslideshow/page'), $pageArray);
        }
    }
    
    public function loadImage(Mage_Core_Model_Abstract $object) {
        return $this->__loadImage($object);
    }
}