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

/**
 * Catalog category helper
 *
 * @category   Codnitive
 * @package    Codnitive_Sidenav
 * @author     Hassan Barza <h.barza@gmail.com>
 */
class Codnitive_Sidenav_Helper_Category extends Mage_Catalog_Helper_Category
{
    /**
     * Retrieve current store categories
     *
     * @param   boolean|string $sorted
     * @param   boolean $asCollection
     * @return  Varien_Data_Tree_Node_Collection|Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection|array
     */
    public function getStoreCategories($sorted=false, $asCollection=false, $toLoad=true)
    {
        $parent     = $this->_getParentCategory();
        $cacheKey   = sprintf('%d-%d-%d-%d', $parent, $sorted, $asCollection, $toLoad);
        if (isset($this->_storeCategories[$cacheKey])) {
            return $this->_storeCategories[$cacheKey];
        }

        /**
         * Check if parent node of the store still exists
         */
        $category = Mage::getModel('catalog/category');
        /**
         * @var $category Mage_Catalog_Model_Category 
         */
        if (!$category->checkId($parent)) {
            if ($asCollection) {
                return new Varien_Data_Collection();
            }
            return array();
        }

        $recursionLevel  = max(0, Mage::getModel('sidenav/config')->getMaxDepth());
        $storeCategories = $category->getCategories($parent, $recursionLevel, $sorted, $asCollection, $toLoad);

        $this->_storeCategories[$cacheKey] = $storeCategories;
        return $storeCategories;
    }
	
	/**
	 * Get parent category defined be user
	 *
	 * @return string|int
	 */
	protected function _getParentCategory()
	{
		$parent 	  = null;
		$parentConfig = Mage::getModel('sidenav/config')->getParent();
		$category 	  = Mage::registry('current_category');
		/**
		 * switch based on RicoNeitzel_VertNav extension
		 * Thanks to Rico Neitzel
		 *
		 */
		switch ($parentConfig) {
			case 'current':
				if ($category) {
					$parent = $category->getId();
				}
				break;
				
			case 'siblings':
				if ($category) {
					$parent = $category->getParentId();
				}
				break;
				
			case 'root':
				$parent = Mage::app()->getStore()->getRootCategoryId();
				break;
				
			default:
				/**
				 * Display from level N
				 */
				$fromLevel = $parentConfig;
				if ($category && $category->getLevel() >= $fromLevel) {
					while ($category->getLevel() > $fromLevel) {
						$category = $category->getParentCategory();
					}
					$parent = $category->getId();
				}
				break;
		}
		return $parent;
	}
	
}
