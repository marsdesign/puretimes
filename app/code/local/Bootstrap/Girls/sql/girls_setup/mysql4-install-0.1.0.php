<?php
$installer = $this;
$installer->startSetup();

$installer->run("
CREATE TABLE IF NOT EXISTS `{$installer->getTable('girls/girls')}` (
  `girls_id` int(11) NOT NULL auto_increment,
  `store_id` int(11),
  `title` varchar(100),
  `description` text,
  `image` varchar(50),
  `link` varchar(100),
  `sort_order` int(11),
  `featured` char(1),
  `active` char(1),
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`girls_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
//demo 

//Mage::getModel('core/url_rewrite')->setId(null);

//demo 
$installer->endSetup();