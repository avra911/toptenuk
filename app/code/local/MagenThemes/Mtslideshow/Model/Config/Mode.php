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
class MagenThemes_Mtslideshow_Model_Config_Mode
{
    private $_modes = array(
                'mtonebyone'  => 'magenthemes/mtslideshow/mtonebyone.phtml',
                'mtcooslider'  => 'magenthemes/mtslideshow/mtcooslider.phtml', 
                'mtflexslider'  => 'magenthemes/mtslideshow/mtflexslider.phtml'
            );
    
    public function toOptionArray()
    {
        return array(
            array('value'=>'mtonebyone', 'label'=>Mage::helper('adminhtml')->__('MT OneByOne')),
            array('value'=>'mtflexslider', 'label'=>Mage::helper('adminhtml')->__('MT FlexSlider')),
            array('value'=>'mtcooslider', 'label'=>Mage::helper('adminhtml')->__('MT CooSlider'))
        );
    }
    
    public function getTemplate($type) {
        foreach($this->_modes as $mode => $template) {
            if($mode == $type) {
                return $template;
            }
        }
        return null;
    }
}
