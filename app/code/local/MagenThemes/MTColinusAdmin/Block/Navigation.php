<?php
class MagenThemes_MTColinusAdmin_Block_Navigation extends Mage_Catalog_Block_Navigation
{
    protected $_column;

    protected function _construct()
    {
        parent::_construct();
    }

    protected function _renderCategoryMenuItemHtml($category, $level = 0, $isLast = false, $isFirst = false,
                                                   $isOutermost = false, $outermostItemClass = '', $childrenWrapClass = '', $noEventAttributes = false)
    {
        if (!$category->getIsActive()) {
            return '';
        }
        $html = array();

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
		$catdetail = Mage::getModel('catalog/category')->load($category->getId());
        $urlkey	= $catdetail->getUrl_key();
        $block = Mage::getModel('cms/block')->load($urlkey);
        $exdrop = explode("\r\n",Mage::getStoreConfig('mtcolinusadmin/navigation/nav_urlkey'));
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
        if(in_array($urlkey,$exdrop)){
        	$classes[] = 'm-dropdown';
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
        $htmlLi = '<li';
        foreach ($attributes as $attrName => $attrValue) {
            $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
        }
        $htmlLi .= '>';
        $html[] = $htmlLi;

        $html[] = '<a href="'.$this->getCategoryUrl($category).'"'.$linkClass.'>';
        $html[] = '<span>' . $this->escapeHtml($category->getName()) . '</span>';
        $html[] = '</a>';
        
        if ($level == 0) {
            $description = $catdetail->getDescription();
            if ($urlkey != $block->getIdentifier() || !Mage::getStoreConfig('mtcolinusadmin/navigation/show_type')) {
                if(in_array($urlkey,$exdrop)){
                    $columns = 1;
                }else{
                    $columns = 5;
                }
            } else {
                if(in_array($urlkey,$exdrop)){
                    $columns = 1;
                }else{
                    $columns = 4;
                }
            }
            $itemspernumb = array_fill(0, $columns, floor($activeChildrenCount / $columns));
            if ($activeChildrenCount % $columns > 0) {
                for ($i = 0; $i < ($activeChildrenCount % $columns); $i++) {
                    $itemspernumb[$i]++;
                }
            }
            $this->_column = array();
        }

        // render children
        $htmlChildren = '';
        $j = 0;
        $i = 0;
        foreach ($activeChildren as $child) {
            $li = $this->_renderCategoryMenuItemHtml(
                $child,
                ($level + 1),
                $isLast,
                ($j == 0),
                false,
                $outermostItemClass,
                $childrenWrapClass,
                $noEventAttributes
            );
            if ($level == 0) {
                $this->_column[] = $li;
            } else {
                $htmlChildren .= $li;
            }
            $j++;
        }
        if ($level == 0 && $this->_column) {
            $i = 0;
            $n = 0;
            foreach ($itemspernumb as $numb) {
                $mages = array_slice($this->_column, $i, $numb);
                $i += $numb;
                if($n==0){
                    $htmlChildren .= '<li class="first"><ol>';
                }elseif (count($this->_column) == $i) {
                    $htmlChildren .= '<li class="last"><ol>';
                }else{
                    $htmlChildren .= '<li><ol>';
                }
                foreach ($mages as $item) {
                    $htmlChildren .= $item;
                }
                $htmlChildren .= '</ol></li>';
                $n++;
            }
        }
        if (!empty($description) && !empty($htmlChildren) && Mage::getStoreConfig('mtcolinusadmin/navigation/show_type')=='category') {
            $htmlChildren .= '<li class="menu-category-description">' . $description;
            if (Mage::getStoreConfig('mtcolinusadmin/navigation/show_learn_more')) {
                $htmlChildren .= '<p><button class="learnmore" onclick="window.location=\'' . $this->getCategoryUrl($category) . '\'"><span><span>' . $this->__('learn more') . '</span></span></button></p>';
            }
            $htmlChildren .= '</li>';
        }else if(!empty($urlkey) && !empty($htmlChildren) && Mage::getStoreConfig('mtcolinusadmin/navigation/show_type')=='static'){
            $htmlChildren .= '<li class="menu-static-blocks">';
            $htmlChildren .= $this->getLayout()->createBlock('cms/block')->setBlockId($urlkey)->toHtml();
            $htmlChildren .= '</li>';
        }

        if (!empty($htmlChildren)) {
            if ($childrenWrapClass) {
                if(in_array($urlkey,$exdrop)){
                    $html[] = '<div class="dropdown ' . $childrenWrapClass . '">';
                }else{
                    $html[] = '<div class="' . $childrenWrapClass . '">';
                }
            }
            $html[] = '<ul class="level' . $level . '">';
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

}