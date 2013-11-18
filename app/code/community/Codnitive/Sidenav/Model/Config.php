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
 * @category   Codnitive
 * @package    Codnitive_Sidenav
 * @author     Hassan Barza <support@codnitive.com>
 * @copyright  Copyright (c) 2011 CODNITIVE Co. (http://www.codnitive.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Catalog category
 *
 * @category   Design
 * @package    Codnitive_Sidenav
 * @author     Hassan Barza <h.barza@gmail.com>
 */
class Codnitive_Sidenav_Model_Config extends Mage_Catalog_Model_Category
{	
	/**
     * Retrieve Thumbnail image URL
     *
     * @return string
     */
    public function getThumbnailImageUrl()
    {
        $url = false;
        if ($image = $this->getThumbnail()) {
            $url = Mage::getBaseUrl('media').'catalog/category/'.$image;
        }
        return $url;
    }
	
	/**
     * Check for extension enable option status
     *
     * @return boolean
     */
	public function checkActive()
	{
		return Mage::getStoreConfig('codnitivecatalog/sidenav/active');
	}
	
	/**
     * Set title
     *
     * @return string
     */
    public function setTitle()
    {
        $title = Mage::getStoreConfig('codnitivecatalog/sidenav/title');
		return !empty($title) ? $title : 'Categories';
    }
	
	/**
     * Check for top navigation remove stting
     *
     * @return boolean
     */
	public function getRemoveTopNav()
	{
		return Mage::getStoreConfig('codnitivecatalog/sidenav/remove_top_nav');
	}
	
	/**
     * Get column option value to define selected column
     *
     * @return string
     */
	public function getColumnValue()
	{
		return Mage::getStoreConfig('codnitivecatalog/sidenav/column');
	}
	
	/**
     * Gets defined parent category
     *
     * @return string
     */
	public function getParent()
	{
		return Mage::getStoreConfig('codnitivecatalog/sidenav/parent');
	}
	
	/**
     * Get gategory maximal depth number
     *
     * @return string
     */
	public function getMaxDepth()
	{
		return Mage::getStoreConfig('codnitivecatalog/sidenav/max_depth');
	}
	
	/**
     * Get collapsible menu status
     *
     * @return boolean
     */
	public function getCollapsible()
	{
		return Mage::getStoreConfig('codnitivecatalog/sidenav/collapsible');
	}
	
	/**
     * Get show product count setting
     *
     * @return boolean
     */
	public function getShowProductCount()
	{
		return Mage::getStoreConfig('codnitivecatalog/sidenav/product_count');
	}
    
    /**
     * Get remove product count for categories by zero product number
     *
     * @return boolean
     */
    public function removeZeroCount()
    {
        return Mage::getStoreConfig('codnitivecatalog/sidenav/remove_zero_count');
    }
	
	/**
     * Check for extension enable option status
     *
     * @return boolean
     */
	public function getThumbImageActive()
	{
		return Mage::getStoreConfig('codnitivecatalog/sidenav/thumbnail');
	}
	
	/**
     * Get thumbnail size setting
     *
     * @return boolean
     */
	public function getThumbSize()
	{
		return Mage::getStoreConfig('codnitivecatalog/sidenav/thumb_size');
	}
	
	/**
     * Get thumbnail width size
     *
     * @return string
     */
	public function getThumbWidth()
	{
		return Mage::getStoreConfig('codnitivecatalog/sidenav/thumb_width');
	}
	
	/**
     * Get thumbnail height size
     *
     * @return string
     */
	public function getThumbHeight()
	{
		return Mage::getStoreConfig('codnitivecatalog/sidenav/thumb_height');
	}
		
}
