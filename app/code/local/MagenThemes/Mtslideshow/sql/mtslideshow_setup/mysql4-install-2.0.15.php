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

DROP TABLE IF EXISTS {$this->getTable('mtslideshow_slide')};
CREATE TABLE {$this->getTable('mtslideshow_slide')} (
  `slide_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `bgmode` varchar(255) NOT NULL,
  `bg_color` varchar(255) NOT NULL,
  `slide_width` varchar(255) NOT NULL,
  `slide_height` varchar(255) NOT NULL,
  `width` smallint(6) unsigned NOT NULL,
  `height` smallint(6) unsigned NOT NULL,  
  `style` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL default '',
  `sort_order` smallint(6) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',  
  PRIMARY KEY (`slide_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('mtslideshow_category')};
CREATE TABLE {$this->getTable('mtslideshow_category')} (
  `slide_id` int(11) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`slide_id`,`category_id`),
  CONSTRAINT `FK_slideshow_category_category` FOREIGN KEY (`category_id`) REFERENCES `{$this->getTable('catalog/category')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_slideshow_category_slide` FOREIGN KEY (`slide_id`) REFERENCES `{$this->getTable('mtslideshow_slide')}` (`slide_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('mtslideshow_page')};
CREATE TABLE {$this->getTable('mtslideshow_page')} (
  `slide_id` int(11) unsigned NOT NULL,
  `page_id` smallint(6) NOT NULL,
  PRIMARY KEY (`slide_id`,`page_id`),
  CONSTRAINT `FK_slideshow_page_page` FOREIGN KEY (`page_id`) REFERENCES `{$this->getTable('cms/page')}` (`page_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_slideshow_page_slide` FOREIGN KEY (`slide_id`) REFERENCES `{$this->getTable('mtslideshow_slide')}` (`slide_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('mtslideshow_image')};
CREATE TABLE {$this->getTable('mtslideshow_image')} (
  `image_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255),
  `title_animate` varchar(255),
  `description` varchar(900),
  `desc_animate` varchar(255),
  `link` varchar(255),  
  `link_animate` varchar(255),
  `file` varchar(255) NOT NULL default '',
  `file_animate` varchar(255),
  `disabled` smallint(6) NOT NULL default '1',
  `slide_id` int(11) unsigned NOT NULL,
  `order` varchar(20) NOT NULL,
  PRIMARY KEY (`image_id`),
  CONSTRAINT `FK_slideshow_slide_image` FOREIGN KEY (`slide_id`) REFERENCES `{$this->getTable('mtslideshow_slide')}` (`slide_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('mtslideshow_store')};
CREATE TABLE {$this->getTable('mtslideshow_store')} (
  `slide_id` int(11) unsigned NOT NULL,
  `store_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`slide_id`,`store_id`),
  CONSTRAINT `FK_slideshow_store_store` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_slideshow_store_slide` FOREIGN KEY (`slide_id`) REFERENCES `{$this->getTable('mtslideshow_slide')}` (`slide_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();