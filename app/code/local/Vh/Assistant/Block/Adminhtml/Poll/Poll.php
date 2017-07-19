<?php
class  Vh_Assistant_Block_Adminhtml_Poll_Poll extends Mage_Adminhtml_Block_Widget_Grid_Container //Mage_Adminhtml_Block_Poll_Poll
{
    public function __construct()
    {
        $this->_controller = 'poll';

		if(Mage::getSingleton('core/session')->getThePollType() == 1){
        	$this->_headerText = Mage::helper('poll')->__('Virgin Hair Style Polls');
			$this->_addButtonLabel = Mage::helper('poll')->__('Add New Poll');
		}else{
        	$this->_headerText = Mage::helper('poll')->__('Poll Manager');
			$this->_addButtonLabel = Mage::helper('poll')->__('Add New Poll');
		}
        parent::__construct();
    }
}
