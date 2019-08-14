<?php
/**
 * @author    Marcin Frymark
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */

$installer = $this;
$installer->startSetup();
$installer->run("

CREATE TABLE {$this->getTable('alekseon_customerComment/comment')} (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` smallint(5) unsigned NOT NULL default '0',
  `customer_email` varchar(255),
  `comment` text NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");
$installer->endSetup();
