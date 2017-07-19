<?php
class Bootstrap_Video_Model_Mysql4_Video_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct(){
	 	//parent::_construct(); tutorial has this
		$this->_init("video/video");
	}
}
	 