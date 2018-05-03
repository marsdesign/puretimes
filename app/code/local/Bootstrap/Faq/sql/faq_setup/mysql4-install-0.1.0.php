<?php
$installer = $this;
$installer->startSetup();

$installer->run("
CREATE TABLE IF NOT EXISTS `{$installer->getTable('faq/faq')}` (
  `faq_id` int(11) NOT NULL auto_increment,
  `store_id` int(11),
  `question` varchar(100),
  `answer` text,
  `sort_order` int(11),
  `active` char(1),
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`faq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
//demo 

//Mage::getModel('core/url_rewrite')->setId(null);

//demo 
$installer->endSetup();