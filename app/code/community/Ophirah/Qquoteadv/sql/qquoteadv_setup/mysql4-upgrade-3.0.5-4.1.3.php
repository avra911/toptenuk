<?php

$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE `{$this->getTable('quoteadv_customer')}` ADD `internal_comment` TEXT DEFAULT NULL AFTER `client_request`;");
$installer->endSetup();
