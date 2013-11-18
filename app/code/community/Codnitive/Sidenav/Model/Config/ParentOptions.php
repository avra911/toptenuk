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
 * @category   Codnitive
 * @package    Codnitive_Sidenav
 * @author     Hassan Barza <support@codnitive.com>
 * @copyright  Copyright (c) 2011 CODNITIVE Co. (http://www.codnitive.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Codnitive_Sidenav_Model_Config_ParentOptions extends Mage_Core_Model_Config_Data
{
    const ROOT_VALUE     = 'root';
	const SIBLINGS_VALUE = 'siblings';
    const CURRENT_VALUE  = 'current';
	
	protected $_options;

    /**
     * Fills the select field with values
     * 
     * @return array
     */
    public function toOptionArray()
    {
		if (!isset($this->_options)) {
			$options = array(
				array(
					'value' => self::ROOT_VALUE,
					'label' => Mage::helper('sidenav')->__('Store Base'),
				),
				array(
					'value' => self::SIBLINGS_VALUE,
					'label' => Mage::helper('sidenav')->__('Current Category and Children'),
				),
				array(
					'value' => self::CURRENT_VALUE,
					'label' => Mage::helper('sidenav')->__('Children of Current Category'),
				),
			);
			/**
			 * Based on RicoNeitzel_VertNav extension
	 		 * Thanks to Rico Neitzel
			 *
			 */
			$resource = Mage::getModel('catalog/category')->getResource();
			$select = $resource->getReadConnection()->select()->reset()
				->from($resource->getTable('catalog/category'), new Zend_Db_Expr('MAX(`level`)'));
			$maxDepth = $resource->getReadConnection()->fetchOne($select);
			for ($i = 2; $i < $maxDepth; $i++) {
				$options[] = array(
					'value' => $i,
					'label' => Mage::helper('sidenav')->__('Category Level %d', $i),
				);
			}
			$this->_options = $options;
		}
		return $this->_options;
    }
}
