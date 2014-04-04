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
class MagenThemes_Mtslideshow_Model_Position extends Varien_Object
{
    const TOP_LEFT	    = 'top_left';
    const BOTTOM_LEFT	    = 'bottom_left';
    const TOP_CONTENT       = 'top_content';
    const BOTTOM_CONTENT    = 'bottom_content';
    const TOP_RIGHT         = 'top_right';
    const BOTTOM_RIGHT      = 'bottom_right';

    static public function getOptionArray()
    {
        return array(
            self::TOP_LEFT          => Mage::helper('mtslideshow')->__('Top Left'),
            self::BOTTOM_LEFT       => Mage::helper('mtslideshow')->__('Bottom Left'),
            self::TOP_CONTENT       => Mage::helper('mtslideshow')->__('Top Content'),
            self::BOTTOM_CONTENT    => Mage::helper('mtslideshow')->__('Bottom Content'),
            self::TOP_RIGHT         => Mage::helper('mtslideshow')->__('Top Right'),
            self::BOTTOM_RIGHT      => Mage::helper('mtslideshow')->__('Bottom Right')
        );
    }
    
    static public function editOptionArray() {
        return array(
                array(
                    'value'     => '',
                    'label'     => Mage::helper('mtslideshow')->__('--- Please Select Position ---'),
                ),
            
                array(
                    'value'     => self::TOP_LEFT,
                    'label'     => Mage::helper('mtslideshow')->__('Top Left'),
                ),

                array(
                    'value'     => self::BOTTOM_LEFT,
                    'label'     => Mage::helper('mtslideshow')->__('Bottom Left'),
                ),
                
                array(
                    'value'     => self::TOP_CONTENT,
                    'label'     => Mage::helper('mtslideshow')->__('Top Content'),
                ),

                array(
                    'value'     => self::BOTTOM_CONTENT,
                    'label'     => Mage::helper('mtslideshow')->__('Bottom Content'),
                ),
                
                array(
                    'value'     => self::TOP_RIGHT,
                    'label'     => Mage::helper('mtslideshow')->__('Top Right'),
                ),

                array(
                    'value'     => self::BOTTOM_RIGHT,
                    'label'     => Mage::helper('mtslideshow')->__('Bottom Right'),
                ),
            );
    }
    
    static public function gridOptionArray() {
        return array(
                self::TOP_LEFT              => Mage::helper('mtslideshow')->__('Top Left'),
                self::BOTTOM_LEFT           => Mage::helper('mtslideshow')->__('Bottom Left'),
                self::TOP_CONTENT           => Mage::helper('mtslideshow')->__('Top Content'),
                self::BOTTOM_CONTENT        => Mage::helper('mtslideshow')->__('Bottom Content'),
                self::TOP_RIGHT             => Mage::helper('mtslideshow')->__('Top Right'),
                self::BOTTOM_RIGHT          => Mage::helper('mtslideshow')->__('Bottom Right'),
          );
    }
}