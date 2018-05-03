<?php
class Bootstrap_Girls_Model_Mysql4_Girls extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("girls/girls", "girls_id");
    }
}