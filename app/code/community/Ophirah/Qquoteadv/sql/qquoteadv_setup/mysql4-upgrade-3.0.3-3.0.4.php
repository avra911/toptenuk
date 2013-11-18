<?php

/** @var $this Ophirah_Qquoteadv_Model_Mysql4_Setup  */
$this->startSetup();

$this->run("
  DROP TABLE IF EXISTS `{$this->getTable('quoteadv_rotation')}`;

  CREATE TABLE `{$this->getTable('quoteadv_rotation')}` (
    `rotation_id` int(10) unsigned NOT NULL auto_increment,
    `user_id` int(10) unsigned NOT NULL,
    `role_id` int(10) unsigned NOT NULL,
    `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
    `updated_at` datetime NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY  (`rotation_id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='Quotes';

  ALTER TABLE `{$this->getTable('quoteadv_rotation')}`
    ADD CONSTRAINT `FK_ quoteadv_rotation_user_id` FOREIGN KEY (`user_id`) REFERENCES `{$this->getTable('admin/user')}` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `FK_ quoteadv_rotation_role_id` FOREIGN KEY (`role_id`) REFERENCES `{$this->getTable('admin/role')}` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$this->endSetup();