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
$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('mtslideshow_slide')} ADD `bgmode` VARCHAR( 20 ) NOT NULL ,
ADD `bg_color` VARCHAR( 20 ) NOT NULL ,
ADD `slide_width` VARCHAR( 20 ) NOT NULL ,
ADD `slide_height` VARCHAR( 20 ) NOT NULL ;  
 
ALTER TABLE {$this->getTable('mtslideshow_image')} ADD `title_animate` VARCHAR( 20 ) NOT NULL, 
ADD `desc_animate` VARCHAR( 20 ) NOT NULL , 
ADD `link_animate` VARCHAR( 20 ) NOT NULL , 
ADD `file_animate` VARCHAR( 20 ) NOT NULL ;
");

$installer->endSetup();