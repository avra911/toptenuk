<?php
class Amasty_Shopby_Block_Catalog_Layer_View extends Mage_Catalog_Block_Layer_View
{
    protected $_filterBlocks = null;
    protected $_blockPos     = 'left';
    
    public function getFilters()
    {
        if (!is_null($this->_filterBlocks)){
            return $this->_filterBlocks;
        }
        
        $filters = parent::getFilters();
        
        // remove some filtes for the home page
        $exclude = Mage::getStoreConfig('amshopby/general/exclude');
        if ('/' == Mage::app()->getRequest()->getRequestString() && $exclude){
            $exclude = explode(',', preg_replace('/[^a-zA-Z0-9_\-,]+/','', $exclude));
            $filters = $this->excludeFilters($filters, $exclude);
        } else {
            $exclude = array();
        }
        
        $categoriesOrder = Mage::getStoreConfig('amshopby/general/categories_order');
        
        /*
         * Hide categories block from layered navigation
         */
        if ($categoriesOrder < 0) {
            $exclude[] = 'category';
        }
        
        // option ids
        $ids = array();        
        foreach ($filters as $f){
            //
            if ($f instanceof Mage_Catalog_Block_Layer_Filter_Category) {
                
                $f->setPosition($categoriesOrder);    
                
            } else if ($f->getItemsCount()) {
                $items = $f->getItems();
                if (isset($items[0])) {
                    $f->setPosition($items[0]->getFilter()->getAttributeModel()->getPosition());
                }
            } else {
                $f->setPosition(0);
            }
            
            if ($f->getItemsCount() && ($f instanceof Mage_Catalog_Block_Layer_Filter_Attribute)){
                $items = $f->getItems();
                foreach ($items as $item){  
                    $vals = array_merge( explode(',', $item->getValue()), array($item->getOptionId())); 
                    foreach ($vals as $v) {
                        $ids[] = $v;
                    }
                }
            }
        }
        
        // images of filter values 
        $optionsCollection = Mage::getResourceModel('amshopby/value_collection')
            ->addFieldToFilter('option_id', array('in' => $ids)) 
            ->load();
                
        $options = array();        
        foreach ($optionsCollection as $row){
            $options[$row->getOptionId()] = array(
                'img' => $row->getImgSmall(),
                'img_hover' => $row->getImgSmallHover(), 
                'descr' => $row->getDescr()
            );
        }

        $catId = $this->getLayer()->getCurrentCategory()->getId();
        
        // update filters with new properties
        $allSelected = array();
        $attributes = $this->_getAttributesSettings();
        foreach ($filters as $f){
            if ($f->getItemsCount() && $f instanceof Mage_Catalog_Block_Layer_Filter_Attribute){
                $items = $f->getItems();
               
                //add selected and image properties for all items                
                $attributeCode = $items[0]->getFilter()->getAttributeModel()->getAttributeCode();
                $selectedValues = Mage::app()->getRequest()->getParam($attributeCode);
                if ($selectedValues){
                    $selectedValues = explode(',', $selectedValues);
                    $f->setHasSelection(true);
                    $allSelected = array_merge($allSelected, $selectedValues);
                }
                else {
                    $selectedValues = array();
                }
                    
                foreach ($items as $item){ 
                    $optId = $item->getOptionId();
                    if (!empty($options[$optId]['img'])){
                        $item->setImage($options[$optId]['img']);
                    }
                    if (!empty($options[$optId]['img_hover'])){
                        $item->setImageHover($options[$optId]['img_hover']);
                    }
                    if (!empty($options[$optId]['descr'])){
                        $item->setDescr($options[$optId]['descr']);
                    }
                    
                    
                    $item->setIsSelected(in_array($optId, $selectedValues));
                }                    
                
                $attributeId  = $items[0]->getFilter()->getAttributeModel()->getId();
                if (isset($attributes[$attributeId])){
                    $a = $attributes[$attributeId];
                    $f->setMaxOptions($a->getMaxOptions());
                    $f->setHideCounts($a->getHideCounts());
                    $f->setSortBy($a->getSortBy());
                    $f->setDisplayType($a->getDisplayType());
                    $f->setSingleChoice($a->getSingleChoice());
                    $f->setSeoRel($a->getSeoRel());
                    // sinse version 1.4.7
                    $f->setDependOn($a->getDependOn());
                    $f->setDependOnAttribute($a->getDependOnAttribute());
                    $f->setAttributeCode($attributeCode);
                    // sinse version 2.0
                    $f->setCollapsed($a->getCollapsed());
                    $f->setComment($a->getComment());
                    
                    $cats = trim(str_replace(' ', '', $a->getExcludeFrom()));
                    if ($cats){
                        if (in_array($catId, explode(',', $cats))){
                            $exclude[] = $attributeCode;
                        }
                    }
                } //if attibute
                
            }// if count items and attribute
            elseif ($f instanceof Mage_Catalog_Block_Layer_Filter_Category){
                $f->setDisplayType(Mage::getStoreConfig('amshopby/general/categories_type'));
                $f->setTemplate('amshopby/category.phtml'); 
                $f->setHasSelection($catId != $this->getLayer()->getCurrentStore()->getRootCategoryId());
                $f->setCollapsed(Mage::getStoreConfig('amshopby/general/categories_collapsed'));
            }
            elseif ($f instanceof Mage_Catalog_Block_Layer_Filter_Price){
                $attrCode = $f->getAttributeModel()->getAttributeCode();
                if ('price' == $attrCode){
                    $f->setDisplayType(Mage::getStoreConfig('amshopby/general/price_type'));
                    $f->setTemplate('amshopby/price.phtml');
                    $f->setSliderType(Mage::getStoreConfig('amshopby/general/slider_type'));
                    $f->setHasSelection(Mage::app()->getRequest()->getParam($attrCode));
                    
                    $currencySign = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();                
                    $f->setValueLabel($currencySign);
                    
                    $f->setValuePlacement('before');
                    $f->setFromToWidget(Mage::getStoreConfig('amshopby/general/price_from_to'));
                    $f->setAttributeCode($attrCode);
                    $f->setCollapsed(Mage::getStoreConfig('amshopby/general/price_collapsed'));
                    $f->setSeoRel(Mage::helper('amshopby')->getSeoPriceRelNofollow());
                }
            }
            elseif ($f instanceof Mage_Catalog_Block_Layer_Filter_Decimal){
                if ($f->getItemsCount()) {
                    $items = $f->getItems();
                    
                    $attributeId  = $items[0]->getFilter()->getAttributeModel()->getId();
                    $attributeCode = $items[0]->getFilter()->getAttributeModel()->getAttributeCode();
                    
                    if (isset($attributes[$attributeId])){
                                        
                        $a = $attributes[$attributeId];
                        $cats = trim(str_replace(' ', '', $a->getExcludeFrom()));
                        
                        $excluded = false;
                        
                        if ($cats){
                            if (in_array($catId, explode(',', $cats))){
                                $exclude[] = $attributeCode;
                                $excluded = true;
                            }
                        }
                        
                        if (!$excluded) {
                            
                            $f->setHideCounts($a->getHideCounts());
                            $f->setDisplayType($a->getDisplayType());
                            $f->setSeoRel($a->getSeoRel());
                            // sinse version 1.4.7
                            $f->setDependOn($a->getDependOn());
                            $f->setDependOnAttribute($a->getDependOnAttribute());
                            // sinse version 2.0
                            $f->setCollapsed($a->getCollapsed());
                            $f->setComment($a->getComment());
                            
                            $f->setFromToWidget($a->getFromToWidget());
                            $f->setSliderType($a->getSliderType());
                            $f->setValueLabel($a->getValueLabel());
                            $f->setValuePlacement($a->getValuePlacement());
                            $f->setAttributeCode($attributeCode);        
                            
                            $f->setHasSelection(Mage::app()->getRequest()->getParam($attributeCode));
                        }
                    }
                }
                $f->setTemplate('amshopby/price.phtml');
            }
        }
        
        //exclude dependant, sinse 1.4.7
        foreach ($filters as $f){
            $ids = trim(str_replace(' ', '', $f->getDependOn()));
            $parentAttributes = trim(str_replace(' ', '', $f->getDependOnAttribute()));
            
            if (!$ids && !$parentAttributes){
                continue;
            }
            if (!empty($ids)) {
                $ids = explode(',', $ids);
                if (!array_intersect($allSelected, $ids)){
                    $exclude[] = $f->getAttributeCode();
                }
            }
            if (!empty($parentAttributes)) {
                $parentAttributes = explode(',', $parentAttributes);
                foreach ($parentAttributes as $parentAttribute) {
                    if (Mage::app()->getRequest()->getParam($parentAttribute)) {
                        $attributePresent = true;                           
                    }
                }
                if (!$attributePresent) {
                    $exclude[] = $f->getAttributeCode();
                }
            }
        }
        
        
        // 1.2.7 exclude some filters from the selected categories
        $filters = $this->excludeFilters($filters, $exclude);
        
        usort($filters, array($this, 'sortFiltersByOrder'));

        $this->_filterBlocks = $filters;
        return $filters;       
    }
    
    public function sortFiltersByOrder($filter1, $filter2) 
    {
        if ($filter1->getPosition() == $filter2->getPosition()) {
            return 0;
        } 
        return $filter1->getPosition() > $filter2->getPosition() ? 1 : -1;
    }
    
    protected function _getFilterableAttributes()
    {
        $attributes = $this->getData('_filterable_attributes');
        if (is_null($attributes)) {
            $settings   = $this->_getAttributesSettings();
            $attributes = $this->getLayer()->getFilterableAttributes();
            
            foreach ($attributes as $k => $v){
                $pos = 'left';
                if (isset($settings[$v->getId()])){
                    $pos = $settings[$v->getId()]->getBlockPos();
                }
                elseif($v->getAttributeCode() == 'price'){
                    $pos = Mage::getStoreConfig('amshopby/block/price_pos');                    
                }
                if ($this->_notInBlock($pos)){
                    $attributes->removeItemByKey($k);
                }
            } 
            
            $this->setData('_filterable_attributes', $attributes);
        }

        return $attributes;
    }    
    
    public function getStateHtml()
    {
        $pos = Mage::getStoreConfig('amshopby/block/state_pos'); 
        if ($this->_notInBlock($pos)){
            return '';
        }
        $this->getChild('layer_state')->setTemplate('amshopby/state.phtml');
        return $this->getChildHtml('layer_state');
    } 
    
    public function canShowBlock()
    {
        if ($this->canShowOptions()){
            return true;
        }
        
        $cnt = 0;
        $pos = Mage::getStoreConfig('amshopby/block/state_pos'); 
        if (!$this->_notInBlock($pos)){
            $cnt = count($this->getLayer()->getState()->getFilters());
        }        
        return $cnt;
    }  
      
    public function getBlockId()
    {
        return 'amshopby-filters-' . $this->_blockPos;
    }       
    
    protected function excludeFilters($filters, $exclude)
    {
        $new = array();
        foreach ($filters as $f){
            $code = substr($f->getData('type'), 1+strrpos($f->getData('type'), '_'));
            if ($f->getAttributeModel()){
                $code = $f->getAttributeModel()->getAttributeCode();
            }
            
            if (in_array($code, $exclude)){
                 continue;
            } 
             
            $new[] = $f;          
        }
        return $new;
    }
    
    protected function _afterToHtml($html)
    {
        $html = parent::_afterToHtml($html);
        
        $queldorei = false;
        if (!$html){
            // compatibility with "shopper" theme
            // @see catalog/layer/view.phtml
            $queldorei_blocks = Mage::registry('queldorei_blocks');
            if ($queldorei_blocks AND !empty($queldorei_blocks['block_layered_nav'])) {
                $html = $queldorei_blocks['block_layered_nav'];
            }
            if (!$html){
                return '';
            }
            $queldorei = true;
        }
        
        $pos = strrpos($html, '</div>');
        if ($pos !== false) {
            //add an overlay before closing tag
            $html = substr($html, 0, strrpos($html, '</div>')) 
                  . '<div style="display:none" class="amshopby-overlay"></div>'
                  . '</div>';
        }

        
        // to make js and css work for 1.3 also
        $html = str_replace('class="narrow-by', 'class="block-layered-nav narrow-by', $html);
        // add selector for ajax
        $html = str_replace('block-layered-nav', 'block-layered-nav ' . $this->getBlockId(), $html);
        
        // we don't want to move this into the template are different in custom themes
        foreach ($this->getFilters() as $f){
            $name = $this->__($f->getName());
            if ($f->getCollapsed() && !$f->getHasSelection()){
                $html = str_replace('<dt>'.$name, '<dt class="amshopby-collapsed">'.$name, $html);
            }
            $comment = $f->getComment();
            if ($comment){
                $img = Mage::getDesign()->getSkinUrl('images/amshopby-tooltip.png');
                $img = '<img class="amshopby-tooltip-img" src="'.$img.'" width="9" height="9" alt="'.htmlspecialchars($comment).'" id="amshopby-img-'.$f->getAttributeCode().'"/>';
                $html = str_replace($name.'</dt>', $name . $img . '</dt>', $html);    
            }
            
        }
        
        if ($queldorei AND !empty($queldorei_blocks['block_layered_nav'])) {
            // compatibility with "shopper" theme
            // @see catalog/layer/view.phtml
            Mage::unregister('queldorei_blocks');
            $queldorei_blocks['block_layered_nav'] = $html;
            Mage::register('queldorei_blocks', $queldorei_blocks);
            return '';
        }
        
        return $html;
    }    

    protected function _prepareLayout()
    {
        $pos = Mage::getStoreConfig('amshopby/block/categories_pos');
        if ($this->_notInBlock($pos)){
            $this->_categoryBlockName = 'amshopby/catalog_layer_filter_empty';   
        }        

        if (Mage::registry('amshopby_layout_prepared')){
            return parent::_prepareLayout();
        }
        else {
            Mage::register('amshopby_layout_prepared', true);
        }
        
        if (!Mage::getStoreConfigFlag('customer/startup/redirect_dashboard')) { 
            $url = Mage::helper('amshopby/url')->getFullUrl($_GET);
            Mage::getSingleton('customer/session')
                ->setBeforeAuthUrl($url);           
        }       
        
        $head = $this->getLayout()->getBlock('head');
        if ($head){
            $head->addJs('amasty/amshopby/amshopby.js');     
             
            if (Mage::getStoreConfigFlag('amshopby/block/ajax') && !$this->getIsProductPage()){
                $head->addJs('amasty/amshopby/amshopby-ajax.js');                 
            }
        }
        
        return parent::_prepareLayout();
    } 
    
    protected function _notInBlock($pos)
    {
        if (!in_array($pos, array('left', 'right', 'top'))){
            $pos = 'left';
        }
        return ($pos != $this->_blockPos);
    }
      
    protected function _getAttributesSettings()
    {
        $attributes = Mage::registry('amshopby_attributes');
        if (!$attributes){
            //additional filter properties
            $attrCollection = Mage::getResourceModel('amshopby/filter_collection')
                ->load();
                    
            $attributes = array();
            foreach ($attrCollection as $row){
                $attributes[$row->getAttributeId()] = $row;
            }
            
        }
        return $attributes;        
    }
    
    protected function _getCategoryFilter()
    {
        if (Mage::helper('amshopby')->isVersionLessThan(1, 4, 2)){
            $pos = Mage::getStoreConfig('amshopby/block/categories_pos');
            if ($this->_notInBlock($pos)){
                $this->_categoryBlockName = 'amshopby/catalog_layer_filter_empty';
                $categryBlock = $this->getLayout()->createBlock($this->_categoryBlockName)
                    ->setLayer($this->getLayer())
                    ->init(); 
                return  $categryBlock;              
            }  
        }
        return parent::_getCategoryFilter();
    }    
    
}