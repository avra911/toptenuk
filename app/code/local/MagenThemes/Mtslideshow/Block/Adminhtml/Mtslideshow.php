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
class MagenThemes_Mtslideshow_Block_Adminhtml_Mtslideshow extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_mtslideshow';
    $this->_blockGroup = 'mtslideshow';
    $this->_headerText = Mage::helper('mtslideshow')->__('Slide Manager');
    $this->_addButtonLabel = Mage::helper('mtslideshow')->__('Add Slide');
    parent::__construct();
  }
}