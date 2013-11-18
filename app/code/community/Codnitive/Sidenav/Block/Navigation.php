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


class Codnitive_Sidenav_Block_Navigation extends Mage_Catalog_Block_Navigation
{
    /**
     * Extension config model object
     *
     */
	protected $_config;
	
	/**
     * Construct parent and define $_config
     *
     */
	protected function _construct()
    {
        parent::_construct();
		$this->_config = Mage::getModel('sidenav/config');
    }
	
	/**
     * Get store categories navigation menu
     *
     * @return string
     */	
	public function getCategoriesNavMenu()
	{
		$navigationMenu = $this->renderCategoriesMenuHtml(0);
		return $navigationMenu ? $navigationMenu : false;
	}
	
	/**
     * Get catagories of current store
     *
     * @return Varien_Data_Tree_Node_Collection
     */
    public function getStoreCategories()
    {
        return Mage::helper('sidenav/category')->getStoreCategories();
    }
	
	/**
     * Render category to html
     *
     * @param Mage_Catalog_Model_Category $category
     * @param int Nesting level number
     * @param boolean Whether ot not this item is last, affects list item class
     * @param boolean Whether ot not this item is first, affects list item class
     * @param boolean Whether ot not this item is outermost, affects list item class
     * @param string Extra class of outermost list items
     * @param string If specified wraps children list in div with this class
     * @param boolean Whether ot not to add on* attributes to list item
     * @return string
     */
    protected function _renderCategoryMenuItemHtml($category, $level = 1, $isLast = false, $isFirst = false,
        $isOutermost = false, $outermostItemClass = '', $childrenWrapClass = '', $noEventAttributes = false)
    {
		if (!$category->getIsActive()) {
			return '';
		}
		$html     = array();
		$js       = null;
		$expanded = null;
		$ulThumb  = '';
		$image    = '';
		$thumb    = '';
		$htmlLi   = '';

		// get all children
		if (Mage::helper('catalog/category_flat')->isEnabled()) {
			$children = (array)$category->getChildrenNodes();
			$childrenCount = count($children);
		} else {
			$children = $category->getChildren();
			$childrenCount = $children->count();
		}
		$hasChildren = ($children && $childrenCount);

		// select active children
		$activeChildren = array();
		foreach ($children as $child) {
			if ($child->getIsActive()) {
				$activeChildren[] = $child;
			}
		}
		$activeChildrenCount = count($activeChildren);
		$hasActiveChildren = ($activeChildrenCount > 0);

		// prepare list item html classes
		$classes = array();
		$classes[] = 'level' . $level;
		$classes[] = 'nav-' . $this->_getItemPosition($level);
		if ($this->isCategoryActive($category)) {
			$classes[] = 'active';
		}
		$linkClass = '';
		if ($isOutermost && $outermostItemClass) {
			$classes[] = $outermostItemClass;
			$linkClass = ' class="'.$outermostItemClass.'"';
		}
		if ($isFirst) {
			$classes[] = 'first';
		}
		if ($isLast) {
			$classes[] = 'last';
		}
		if ($hasActiveChildren) {
			$classes[] = 'parent';
		}

		// prepare list item attributes
		$attributes = array();
		if (count($classes) > 0) {
			$attributes['class'] = implode(' ', $classes);
		}
		if ($hasActiveChildren && !$noEventAttributes) {
			 $attributes['onmouseover'] = 'toggleMenu(this,1)';
			 $attributes['onmouseout'] = 'toggleMenu(this,0)';
		}

		// assemble list item with attributes
		$config   	   = Mage::getModel('sidenav/config');
		$thumbWidth    = 14;
		$thumbHeight   = 14;
		$liMarginLeft  = 0;
		$ulMarginLeft  = 5;
		$ulPaddingLeft = 10;
		
		// define image thumbnail variables
		if ($config->getThumbImageActive()) {
			if ($config->getThumbSize()) {
				$thumbWidth  = $config->getThumbWidth();
				$thumbHeight = $config->getThumbHeight();
			}
			$thumbnail = $config->load($category->getId())->getThumbnailImageUrl();
			$ulThumb   = ' ul-thumb';
			if (!empty($thumbnail)) {
				$image = '<img src="'.$thumbnail.'" style= "width:'.$thumbWidth.'px; height:'.$thumbHeight.'px; float: left;" />';
				$thumb = ' thumb';
				if ($config->getCollapsible() && $config->getThumbImageActive()) {
				    $liMarginLeft = $thumbWidth + 3;
				    $ulMarginLeft = 0;
				}
				else {
    				$liMarginLeft = 0;
    				$ulMarginLeft = $thumbWidth + 3;
				}
				$ulPaddingLeft = 0;
			} 
			else {
				$thumb = ' no-thumb';
				$liMarginLeft  = $thumbWidth + 3;
				$ulMarginLeft  = 0;
				$ulPaddingLeft = 0;
			}
		}
		
		$htmlLi .= '<li';
		foreach ($attributes as $attrName => $attrValue) {
			$htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . $thumb . '"';
		}
		$htmlLi .= ' style="margin-left: ' . $liMarginLeft . 'px;">';
		$html[] = $htmlLi;
		
		// add collapsible arrow and wrraper
		if ($config->getCollapsible()) {
		    $width = 8;
		    $height = 0;
		    $expanded = 0;
		    if ($hasActiveChildren) {
		        $width = 8;
		        $height = 10;
		    }
		    if ($this->isCategoryActive($category)) {
		        $expanded = 1;
		    }
		    $html[] = '<span class="arrow" onclick="expandMenu(this.parentNode)" 
		    	style="width: ' . $width . 'px; height: ' . $height . 'px;"></span>';
		}
		
		// add thumbnail image
		$html[] = $image;
		
		// add wrapper
		if ($config->getCollapsible() || $config->getThumbImageActive()) {
		    $wrapperMargin = $config->getCollapsible() ? 14 : 0;
		    /*if ($config->getThumbImageActive()) {
		        $extraMargin = !empty($thumbnail) ? $thumbWidth + 3 : 0;
		    }*/
		    $extraMargin = !$config->getThumbImageActive() ? 0 : !empty($thumbnail) ? $thumbWidth + 3 : 0;
		    $collWrapper = $wrapperMargin + $extraMargin;
		    $html[] = '<div class="collapsible-wrapper" style="margin-left: ' . $collWrapper . 'px;">';
		}
		
		$html[] = '<a href="' . $this->getCategoryUrl($category) . '"'
		    . $linkClass.'><span class="category_name">' 
		    . $this->escapeHtml($category->getName()) . '</span></a>';
//        $html[] = '<span class="category_name">' . $this->escapeHtml($category->getName()) . '</span></a>';
//        $html[] = '</a>';
        
        // add product count
        if ($config->getShowProductCount()) {
            $count = Mage::getModel('catalog/layer')
                ->setCurrentCategory($category->getID())
                ->getProductCollection()
                ->getSize();
            if (($config->removeZeroCount() && $count > 0) || !$config->removeZeroCount()) {
                $html[] = '<span class="product-count">(' . $count . ')</span>';
            }
        }
        
        // close wrapper
        if ($config->getCollapsible() || $config->getThumbImageActive()) {
		    $html[] = '</div>';
        }

		// render children
		$htmlChildren = '';
		$j = 0;
		$currentLevel = $level;
		$nextLevel = $currentLevel + 1;
	
		foreach ($activeChildren as $child) {
			$htmlChildren .= $this->_renderCategoryMenuItemHtml(
				$child,
				($level + 1),
				($j == $activeChildrenCount - 1),
				($j == 0),
				false,
				$outermostItemClass,
				$childrenWrapClass,
				$noEventAttributes
			);
			$j++;
		}
	
		if (!empty($htmlChildren)) {
			if ($childrenWrapClass) {
				$html[] = '<div class="' . $childrenWrapClass . '">';
			}
			$html[] = '<ul class="level' . $level . $ulThumb . 
				'" style="margin-left: ' . $ulMarginLeft . 
				'px; padding-left: ' . $ulPaddingLeft . '">';
			$html[] = $htmlChildren;
			$html[] = '</ul>';
			if ($childrenWrapClass) {
				$html[] = '</div>';
			}
		}

		$html[] = '</li>';

		$html = implode("\n", $html);
		return $html;
    }
	
	/**
     * Render categories menu in HTML
     *
     * @param int Level number for list item class to start from
     * @param string Extra class of outermost list items
     * @param string If specified wraps children list in div with this class
     * @return string
     */
    public function renderCategoriesMenuHtml($level = 1, $outermostItemClass = '', $childrenWrapClass = '')
    {
        $activeCategories = array();
        foreach ($this->getStoreCategories() as $child) {
            if ($child->getIsActive()) {
                $activeCategories[] = $child;
            }
        }
        $activeCategoriesCount = count($activeCategories);
        $hasActiveCategoriesCount = ($activeCategoriesCount > 0);

        if (!$hasActiveCategoriesCount) {
            return '';
        }

        $html = '';
        $j = 0;
        foreach ($activeCategories as $category) {
            $html .= $this->_renderCategoryMenuItemHtml(
                $category,
                $level,
                ($j == $activeCategoriesCount - 1),
                ($j == 0),
                true,
                $outermostItemClass,
                $childrenWrapClass,
                true
            );
            $j++;
        }

        return $html;
    }
	
	/**
     * Get extension enable status
     *
     * @deprecated after 1.7.20
     *     We don't need to check for module activation option
     *     in template, we check it in layout.
     * 
     * @return boolean
     */
	public function getCheckActive()
	{
		return $this->_config->checkActive();
	}
	
	/**
     * Get selected column
     *
     * @deprecated after 1.7.20
     *     We don't need to check for selected column option
     *     in template, we check it in layout.
     * 
     * @return string
     */
	public function getColumn()
	{
		return $this->_config->getColumnValue();
	}
	
	/**
     * Get category title
     *
     * @return string
     */
	public function getTitle()
	{
		return $this->_config->setTitle();
	}
	}