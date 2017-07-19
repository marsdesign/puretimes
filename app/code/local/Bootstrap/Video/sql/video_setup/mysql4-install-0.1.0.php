<?php
$installer = $this;
$installer->startSetup();

$installer->run("
CREATE TABLE IF NOT EXISTS `{$installer->getTable('video/video')}` (
  `video_id` int(11) NOT NULL auto_increment,
  `store_id` int(11),
  `title` varchar(100),
  `description` text,
  `image` varchar(50),
  `video` varchar(100),
  `sort_order` int(11),
  `featured` char(1),
  `product_id` int(11),
  `type_id` int(11),
  `active` char(1),
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
//demo 

//Mage::getModel('core/url_rewrite')->setId(null);

//demo 
$installer->endSetup();