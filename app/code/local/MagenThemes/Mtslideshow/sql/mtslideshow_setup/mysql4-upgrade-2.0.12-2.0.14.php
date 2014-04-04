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
$conn = $installer->getConnection();
$imageTable = $this->getTable('mtslideshow_image');
if (!$conn->tableColumnExists($imageTable, 'order')) {
    $installer->run("ALTER TABLE {$imageTable} ADD `order` VARCHAR( 20 ) NOT NULL;");
}
$installer->endSetup();