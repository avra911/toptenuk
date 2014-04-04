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
class MagenThemes_Mtslideshow_Model_Config extends Mage_Catalog_Model_Product_Media_Config {

    public function getBaseMediaPath() {
        return Mage::getBaseDir('media') .DS. 'mtslideshow';
    }

    public function getBaseMediaUrl() {
        return Mage::getBaseUrl('media') . 'mtslideshow';
    }

    public function getBaseTmpMediaPath() {
        return Mage::getBaseDir('media') .DS. 'tmp' .DS. 'mtslideshow';
    }

    public function getBaseTmpMediaUrl() {
        return Mage::getBaseUrl('media') . 'tmp/mtslideshow';
    }

}