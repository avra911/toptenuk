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
class MagenThemes_Mtslideshow_Model_Layout_Generate_Observer
{
    public function addJsCss(Varien_Event_Observer $observer) {
        $layout = Mage::getSingleton('core/layout');
        $headBlock = $observer->getLayout()->getBlock('head');
        if(Mage::helper('mtslideshow')->isActive()) {
            if(Mage::app()->getFrontController()->getRequest()->getRouteName() == 'cms') {
                $pageId = Mage::getBlockSingleton('cms/page')->getPage()->getPageId();              
                $pages = Mage::getModel('mtslideshow/page')->getCollection()->addFilter('page_id', $pageId);
                foreach($pages as $page) {
                    if($pageId == $page->getPageId()) {
						$slide = Mage::getModel('mtslideshow/mtslideshow')->load($page->getSlideId());
						if($slide->getStyle()=='mtcooslider'){
                            $headBlock->addCss('magenthemes/mtslideshow/themes/mtcooslider/cooslider.css');
                            $headBlock->addCss('magenthemes/mtslideshow/themes/mtcooslider/animate.css');
						}else if($slide->getStyle()=='mtflexslider'){
							$headBlock->addCss('magenthemes/mtslideshow/themes/mtflexslider/mtflexslider.css');
						}else if($slide->getStyle()=='mtonebyone'){
                            $headBlock->addCss('magenthemes/mtslideshow/themes/mtonebyone/onebyone.css');
                            $headBlock->addCss('magenthemes/mtslideshow/themes/mtonebyone/animate.css');
                            $headBlock->addCss('magenthemes/mtslideshow/themes/mtonebyone/responsive.css');
                        }
                        $headBlock->addJs('magenthemes/mtslideshow/jquery/1.8.2/jquery.1.8.2.min.js');
                        $headBlock->addJs('magenthemes/mtslideshow/noConflict.js');
						if($slide->getStyle()=='mtcooslider'){
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.mousewheel.js');
                            $headBlock->addJs('magenthemes/mtslideshow/coo.slider.min.js');
						}else if($slide->getStyle()=='mtflexslider'){
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.flexslider.js');
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.easing-1.3.js');
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.mousewheel.js');
						}else if($slide->getStyle()=='mtonebyone'){
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.onebyone.js');
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.touchwipe.js');
                        }
                    }                    
                }
            }
            if(Mage::app()->getFrontController()->getRequest()->getRouteName() == 'catalog') {                
				$layer = Mage::getSingleton('catalog/layer');
				$category = $layer->getCurrentCategory();
				$currentCategoryId= $category->getId();
                $categories = Mage::getModel('mtslideshow/category')->getCollection()->addFilter('category_id', $currentCategoryId);
                foreach($categories as $category) {                    
                    if($currentCategoryId == $category->getCategoryId()) {
						$slide = Mage::getModel('mtslideshow/mtslideshow')->load($category->getSlideId());
						if($slide->getStyle()=='mtcooslider'){
                            $headBlock->addCss('magenthemes/mtslideshow/themes/mtcooslider/cooslider.css');
                            $headBlock->addCss('magenthemes/mtslideshow/themes/mtcooslider/animate.css');
						}else if($slide->getStyle()=='mtflexslider'){
							$headBlock->addCss('magenthemes/mtslideshow/themes/mtflexslider/mtflexslider.css');
						}else if($slide->getStyle()=='mtonebyone'){
                            $headBlock->addCss('magenthemes/mtslideshow/themes/mtonebyone/onebyone.css');
                            $headBlock->addCss('magenthemes/mtslideshow/themes/mtonebyone/animate.css');
                            $headBlock->addCss('magenthemes/mtslideshow/themes/mtonebyone/responsive.css');
                        }
                        $headBlock->addJs('magenthemes/mtslideshow/jquery/1.8.2/jquery.1.8.2.min.js');
                        $headBlock->addJs('magenthemes/mtslideshow/noConflict.js');  
						if($slide->getStyle()=='mtcooslider'){
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.mousewheel.js');
                            $headBlock->addJs('magenthemes/mtslideshow/coo.slider.min.js');
						}else if($slide->getStyle()=='mtflexslider'){
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.flexslider.js');
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.easing-1.3.js');
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.mousewheel.js');
						}else if($slide->getStyle()=='mtonebyone'){
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.onebyone.js');
                            $headBlock->addJs('magenthemes/mtslideshow/jquery.touchwipe.js');
                        }
                    }                    
                }
            }            
        }        
    }
}