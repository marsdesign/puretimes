<?php
class Bootstrap_Video_Block_Adminhtml_Video extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
		// blockGroup/controller must match declaration in video.xml
		// video/adminhtml_video
		// ie: blockGroup/controller = video/adminhtml_video
     	$this->_blockGroup = 'video';
     	$this->_controller = 'adminhtml_video';
     	//text in the admin header
     	$this->_headerText = 'Manage Video';
     	//value of the add button
     	$this->_addButtonLabel = 'Add Video Item';
     	parent::__construct();
     }
}