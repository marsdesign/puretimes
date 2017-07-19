<?php
class Bootstrap_Video_Model_Mysql4_Video extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("video/video", "video_id");
    }
}