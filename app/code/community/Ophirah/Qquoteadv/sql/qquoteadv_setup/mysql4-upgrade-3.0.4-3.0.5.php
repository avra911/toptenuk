<?php

/** @var $this Ophirah_Qquoteadv_Model_Mysql4_Setup  */
$this->startSetup();

$this->getConnection()->addColumn($this->getTable('admin/user'), 'telephone', 'TEXT NULL');

$this->endSetup();