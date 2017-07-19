<?php
class Bootstrap_Girls_Block_Adminhtml_Girls extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
		// blockGroup/controller must match declaration in girls.xml
		// girls/adminhtml_girls
		// ie: blockGroup/controller = girls/adminhtml_girls
     	$this->_blockGroup = 'girls';
     	$this->_controller = 'adminhtml_girls';
     	//text in the admin header
     	$this->_headerText = 'Manage Lookbook';
     	//value of the add button
     	$this->_addButtonLabel = 'Add Item';
     	parent::__construct();
     }
}