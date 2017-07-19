<?php
class Bootstrap_Girls_Model_Mysql4_Girls_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct(){
	 	//parent::_construct(); tutorial has this
		$this->_init("girls/girls");
	}
}
	 