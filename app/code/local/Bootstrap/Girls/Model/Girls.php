<?php
class Bootstrap_Girls_Model_Girls extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
		$this->_init('girls/girls');
    }
}