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
 * Catalog product abstract price backend attribute model with customer group specific
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
abstract class Ophirah_Qquoteadv_Model_Mysql4_Catalog_Product_Attribute_Backend_Qquoteadv_Group_Abstract
    extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Load Tier Prices for product
     *
     * @param int $productId
     * @param int $websiteId
     * @return Mage_Catalog_Model_Resource_Product_Attribute_Backend_Tierprice
     */
    public function loadGroupData($productId, $websiteId = null)
    {
        
     
        
        $adapter = $this->_getReadAdapter();

        $columns = array(
            'value_id'      => $this->getIdFieldName(),
            'website_id'    => 'website_id',
            'all_groups'    => 'all_groups',
            'cust_group'    => 'customer_group_id',
            'value'         => 'value',
        );

        $select  = $adapter->select()
            ->from($this->getMainTable(), $columns)
            ->where('entity_id=?', $productId);

        if (!is_null($websiteId)) {
            if ($websiteId == '0') {
                $select->where('website_id = ?', $websiteId);
            } else {
                $select->where('website_id IN(?)', array(0, $websiteId));
            }
        }
        
        return $adapter->fetchAll($select);
    }

    /**
     * Delete Tier Prices for product
     *
     * @param int $productId
     * @param int $websiteId
     * @param int $priceId
     * @return int The number of affected rows
     */
    public function deleteGroupData($productId, $websiteId = null, $priceId = null)
    {
        $adapter = $this->_getWriteAdapter();

        $conds   = array(
            $adapter->quoteInto('entity_id = ?', $productId)
        );

        if (!is_null($websiteId)) {
            $conds[] = $adapter->quoteInto('website_id = ?', $websiteId);
        }

        if (!is_null($priceId)) {
            $conds[] = $adapter->quoteInto($this->getIdFieldName() . ' = ?', $priceId);
        }

        $where = implode(' AND ', $conds);

        return $adapter->delete($this->getMainTable(), $where);
    }

    /**
     * Save tier price object
     *
     * @param Varien_Object $priceObject
     * @return Mage_Catalog_Model_Resource_Product_Attribute_Backend_Tierprice
     */
    public function saveGroupData(Varien_Object $groupObject)
    {
        $adapter = $this->_getWriteAdapter();
        $data    = $this->_prepareDataForTable($groupObject, $this->getMainTable());
       
        if (!empty($data[$this->getIdFieldName()])) {
            $where = $adapter->quoteInto($this->getIdFieldName() . ' = ?', $data[$this->getIdFieldName()]);
            unset($data[$this->getIdFieldName()]);
            $adapter->update($this->getMainTable(), $data, $where);
        } else {
            $adapter->insert($this->getMainTable(), $data);
        }
        return $this;
    }
}
