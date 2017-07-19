<?php
class Vh_Assistant_Block_Adminhtml_Poll_Edit extends Mage_Adminhtml_Block_Poll_Edit
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_controller = 'poll';

        $this->_updateButton('save', 'label', Mage::helper('poll')->__('Save Poll'));
        $this->_updateButton('delete', 'label', Mage::helper('poll')->__('Delete Poll'));

        $this->setValidationUrl($this->getUrl('*/*/validate', array('id' => $this->getRequest()->getParam($this->_objectId))));
    }

    public function getHeaderText()
    {
        if( Mage::registry('poll_data') && Mage::registry('poll_data')->getId() ) {
			if(Mage::getSingleton('core/session')->getThePollType() == 1){
				return Mage::helper('poll')->__("Edit Poll '%s'", $this->escapeHtml(Mage::registry('poll_data')->getAltPollTitle()));
			}else{
				return Mage::helper('poll')->__("Edit Poll '%s'", $this->escapeHtml(Mage::registry('poll_data')->getPollTitle()));
			}
        } else {
            return Mage::helper('poll')->__('New Poll');
        }
    }
}
