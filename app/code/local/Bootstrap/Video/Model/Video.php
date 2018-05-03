<?php
class Bootstrap_Video_Model_Video extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
		$this->_init('video/video');
    }
}