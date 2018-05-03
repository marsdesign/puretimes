<?php
class Bootstrap_Faq_Block_Adminhtml_Faq extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
		// blockGroup/controller must match declaration in faq.xml
		// faq/adminhtml_faq
		// ie: blockGroup/controller = faq/adminhtml_faq
     	$this->_blockGroup = 'faq';
     	$this->_controller = 'adminhtml_faq';
     	//text in the admin header
     	$this->_headerText = 'Manage FAQ';
     	//value of the add button
     	$this->_addButtonLabel = 'Add FAQ Item';
     	parent::__construct();
     }
}