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
class MagenThemes_Mtslideshow_Block_Adminhtml_Mtslideshow_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('mtslideshow_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('mtslideshow')->__('Slide Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('mtslideshow')->__('Slide Information'),
          'title'     => Mage::helper('mtslideshow')->__('Slide Information'),
          'content'   => $this->getLayout()->createBlock('mtslideshow/adminhtml_mtslideshow_edit_tab_form')->toHtml(),
      ));
      
      $this->addTab('image_section', array(
            'label'     => Mage::helper('mtslideshow')->__('Images'),
            'title'     => Mage::helper('mtslideshow')->__('Images'),
            'content'   => $this->getLayout()->createBlock('mtslideshow/adminhtml_mtslideshow_edit_tab_image')->toHtml(),
      ));
      
      $this->addTab('category_section', array(
            'label'     => Mage::helper('mtslideshow')->__('Display on Categories'),
            'title'     => Mage::helper('mtslideshow')->__('Display on Categories'),
            'content'   => $this->getLayout()->createBlock('mtslideshow/adminhtml_mtslideshow_edit_tab_category')->toHtml(),
      ));
      
      $this->addTab('page_section', array(
            'label'     => Mage::helper('mtslideshow')->__('Display on CMS Page'),
            'title'     => Mage::helper('mtslideshow')->__('Display on CMS Page'),
            'content'   => $this->getLayout()->createBlock('mtslideshow/adminhtml_mtslideshow_edit_tab_page')->toHtml(),
      ));
      
      return parent::_beforeToHtml();
  }
}