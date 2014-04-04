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
class MagenThemes_Mtslideshow_Model_Config_Bgmode
{ 
    public function toOptionArray()
    {
        return array(
            array('value'=>'bgimages', 'label'=>Mage::helper('adminhtml')->__('Background images random')),
            array('value'=>'bgcolor', 'label'=>Mage::helper('adminhtml')->__('Background color'))
        );
    } 
}
