<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Catalog product abstract group price backend attribute model
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
abstract class Ophirah_Qquoteadv_Model_Catalog_Product_Attribute_Backend_Qquoteadv_Group_Abstract
   extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
  
    
    /**
     * Validate group price data
     *
     * @param Mage_Catalog_Model_Product $object
     * @throws Mage_Core_Exception
     * @return bool
     */
    public function validate($object)
    {
        /*$attribute = $this->getAttribute();
        $priceRows = $object->getData($attribute->getName());
        if (empty($priceRows)) {
            return true;
        }

        // validate per website
        $duplicates = array();
        foreach ($priceRows as $priceRow) {
            if (!empty($priceRow['delete'])) {
                continue;
            }
            $compare = join('-', array_merge(
                array($priceRow['website_id'], $priceRow['cust_group']),
                $this->_getAdditionalUniqueFields($priceRow)
            ));
            if (isset($duplicates[$compare])) {
                Mage::throwException($this->_getDuplicateErrorMessage());
            }
            $duplicates[$compare] = true;
        }

        // if attribute scope is website and edit in store view scope
        // add global group prices for duplicates find
        if (!$attribute->isScopeGlobal() && $object->getStoreId()) {
            $origGroupPrices = $object->getOrigData($attribute->getName());
            foreach ($origGroupPrices as $price) {
                if ($price['website_id'] == 0) {
                    $compare = join('-', array_merge(
                        array($price['website_id'], $price['cust_group']),
                        $this->_getAdditionalUniqueFields($price)
                    ));
                    $duplicates[$compare] = true;
                }
            }
        }

        // validate currency
        $baseCurrency = Mage::app()->getBaseCurrencyCode();
        $rates = $this->_getWebsiteCurrencyRates();
        foreach ($priceRows as $priceRow) {
            if (!empty($priceRow['delete'])) {
                continue;
            }
            if ($priceRow['website_id'] == 0) {
                continue;
            }

            $globalCompare = join('-', array_merge(
                array(0, $priceRow['cust_group']),
                $this->_getAdditionalUniqueFields($priceRow)
            ));
            $websiteCurrency = $rates[$priceRow['website_id']]['code'];

            if ($baseCurrency == $websiteCurrency && isset($duplicates[$globalCompare])) {
                Mage::throwException($this->_getDuplicateErrorMessage());
            }
        }
        */
        return true;
    }

  
    /**
     * Assign group prices to product data
     *
     * @param Mage_Catalog_Model_Product $object
     * @return Mage_Catalog_Model_Product_Attribute_Backend_Groupprice_Abstract
     */
    public function afterLoad($object)
    {
        
        $storeId   = $object->getStoreId();
        $websiteId = null;
        if ($this->getAttribute()->isScopeGlobal()) {
            $websiteId = 0;
        } else if ($storeId) {
            $websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
        }

        $data = $this->_getResource()->loadGroupData($object->getId(), $websiteId);
        foreach ($data as $k => $v) {
            //$data[$k]['website_price'] = $v['price'];
            if ($v['all_groups']) {
                $data[$k]['cust_group'] = Mage_Customer_Model_Group::CUST_GROUP_ALL;
            }
        }

      
        $object->setData($this->getAttribute()->getName(), $data);
        $object->setOrigData($this->getAttribute()->getName(), $data);

        $valueChangedKey = $this->getAttribute()->getName() . '_changed';
        $object->setOrigData($valueChangedKey, 0);
        $object->setData($valueChangedKey, 0);
        
        return $this;
    }

    /**
     * After Save Attribute manipulation
     *
     * @param Mage_Catalog_Model_Product $object
     * @return Mage_Catalog_Model_Product_Attribute_Backend_Groupprice_Abstract
     */
    public function afterSave($object)
    {
        
        $websiteId  = Mage::app()->getStore($object->getStoreId())->getWebsiteId();
        $isGlobal   = $this->getAttribute()->isScopeGlobal() || $websiteId == 0;
        $groupRows =  $object->getData($this->getAttribute()->getName());
        
       
        
         if (empty( $groupRows)) {
             $this->_getResource()->deleteGroupData($object->getId());
             return $this;
         }
         
         $old = array();
         $new = array();
        
         $origGroupRows = $object->getOrigData($this->getAttribute()->getName());
         if (!is_array( $origGroupRows )) {
             $origGroupRows  = array();
         }
        foreach ( $origGroupRows  as $data) {
            if ($data['website_id'] > 0 || ($data['website_id'] == '0' && $isGlobal)) {
                $key = join('-', array_merge(
                    array($data['website_id'], $data['cust_group']),
                    $this->_getAdditionalUniqueFields($data)
                ));
                $old[$key] = $data;
            }
        }
        
        // prepare data for save
        foreach ($groupRows as $data) {
            $hasEmptyData = false;
            foreach ($this->_getAdditionalUniqueFields($data) as $field) {
                if (empty($field)) {
                    $hasEmptyData = true;
                    break;
                }
            }

            if ($hasEmptyData || !isset($data['cust_group']) || !empty($data['delete'])) {
                continue;
            }
            if ($this->getAttribute()->isScopeGlobal() && $data['website_id'] > 0) {
                continue;
            }
            if (!$isGlobal && (int)$data['website_id'] == 0) {
                continue;
            }

            if(!isset($data['website_id'])) $data['website_id'] =0;
            
            $key = join('-', array_merge(
                array($data['website_id'], $data['cust_group']),
                $this->_getAdditionalUniqueFields($data)
            ));

            $useForAllGroups = $data['cust_group'] == Mage_Customer_Model_Group::CUST_GROUP_ALL;
            $customerGroupId = !$useForAllGroups ? $data['cust_group'] : 0;

            
            $new[$key] = array_merge(array(
                'website_id'        => $data['website_id'],
                'all_groups'        => $useForAllGroups ? 1 : 0,
                'customer_group_id' => $customerGroupId,
                'value'             => $data['value'],
            ), $this->_getAdditionalUniqueFields($data));
        }

        $delete = array_diff_key($old, $new);
        $insert = array_diff_key($new, $old);
        $update = array_intersect_key($new, $old);

        $isChanged  = false;
        $productId  = $object->getId();

        if (!empty($delete)) {
            foreach ($delete as $data) {
                $this->_getResource()->deleteGroupData($productId, null, $data['group_id']);
                $isChanged = true;
            }
        }

        if (!empty($insert)) {
            foreach ($insert as $data) {
                $group = new Varien_Object($data);
                $group->setEntityId($productId);
                $this->_getResource()->saveGroupData($group);

                $isChanged = true;
            }
        }

        if (!empty($update)) {
            foreach ($update as $k => $v) {
                
              
                
                if ($old[$k]['value'] != $v['value']) {
                    $group = new Varien_Object(array(
                        'value_id'  => $old[$k]['value_id'],
                        'value'     => $v['value']
                    ));
                    $this->_getResource()->saveGroupData($group);

                    $isChanged = true;
                }
            }
        }

        if ($isChanged) {
            $valueChangedKey = $this->getAttribute()->getName() . '_changed';
            $object->setData($valueChangedKey, 1);
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        /*$websiteId  = Mage::app()->getStore($object->getStoreId())->getWebsiteId();
        $isGlobal   = $this->getAttribute()->isScopeGlobal() || $websiteId == 0;

        $priceRows = $object->getData($this->getAttribute()->getName());
        if (empty($priceRows)) {
            if ($isGlobal) {
                $this->_getResource()->deletePriceData($object->getId());
            } else {
                $this->_getResource()->deletePriceData($object->getId(), $websiteId);
            }
            return $this;
        }

        $old = array();
        $new = array();

        // prepare original data for compare
        $origGroupPrices = $object->getOrigData($this->getAttribute()->getName());
        if (!is_array($origGroupPrices)) {
            $origGroupPrices = array();
        }
        foreach ($origGroupPrices as $data) {
            if ($data['website_id'] > 0 || ($data['website_id'] == '0' && $isGlobal)) {
                $key = join('-', array_merge(
                    array($data['website_id'], $data['cust_group']),
                    $this->_getAdditionalUniqueFields($data)
                ));
                $old[$key] = $data;
            }
        }

        // prepare data for save
        foreach ($priceRows as $data) {
            $hasEmptyData = false;
            foreach ($this->_getAdditionalUniqueFields($data) as $field) {
                if (empty($field)) {
                    $hasEmptyData = true;
                    break;
                }
            }

            if ($hasEmptyData || !isset($data['cust_group']) || !empty($data['delete'])) {
                continue;
            }
            if ($this->getAttribute()->isScopeGlobal() && $data['website_id'] > 0) {
                continue;
            }
            if (!$isGlobal && (int)$data['website_id'] == 0) {
                continue;
            }

            $key = join('-', array_merge(
                array($data['website_id'], $data['cust_group']),
                $this->_getAdditionalUniqueFields($data)
            ));

            $useForAllGroups = $data['cust_group'] == Mage_Customer_Model_Group::CUST_GROUP_ALL;
            $customerGroupId = !$useForAllGroups ? $data['cust_group'] : 0;

            $new[$key] = array_merge(array(
                'website_id'        => $data['website_id'],
                'all_groups'        => $useForAllGroups ? 1 : 0,
                'customer_group_id' => $customerGroupId,
                'value'             => $data['price'],
            ), $this->_getAdditionalUniqueFields($data));
        }

        $delete = array_diff_key($old, $new);
        $insert = array_diff_key($new, $old);
        $update = array_intersect_key($new, $old);

        $isChanged  = false;
        $productId  = $object->getId();

        if (!empty($delete)) {
            foreach ($delete as $data) {
                $this->_getResource()->deletePriceData($productId, null, $data['price_id']);
                $isChanged = true;
            }
        }

        if (!empty($insert)) {
            foreach ($insert as $data) {
                $price = new Varien_Object($data);
                $price->setEntityId($productId);
                $this->_getResource()->savePriceData($price);

                $isChanged = true;
            }
        }

        if (!empty($update)) {
            foreach ($update as $k => $v) {
                if ($old[$k]['price'] != $v['value']) {
                    $price = new Varien_Object(array(
                        'value_id'  => $old[$k]['price_id'],
                        'value'     => $v['value']
                    ));
                    $this->_getResource()->savePriceData($price);

                    $isChanged = true;
                }
            }
        }

        if ($isChanged) {
            $valueChangedKey = $this->getAttribute()->getName() . '_changed';
            $object->setData($valueChangedKey, 1);
        }*/

        return $this;
    }
    
    protected function _getAdditionalUniqueFields($data){
        return array();
    }
}