<?php   
class Vh_Assistant_Block_Index extends Mage_Core_Block_Template{   

    public function __construct() {
        parent::__construct();
		
		$poll = Mage::getModel('poll/poll')
		->getCollection()
		->addFieldToFilter('poll_type', array('eq' => 1))
		->addFieldToFilter('active', array('eq' => 1))
		->addFieldToFilter('closed', array('eq' => 0))
		->getLastItem();
		
		if(Mage::getSingleton('core/session')->getReferredBack()){
			$this->assign('referred_back', 1);
		}else{
			$this->assign('referred_back', 0);
		}
		Mage::getSingleton('core/session')->setReferredBack(0);
		$this->assign('the_poll_id', $poll->getId());
    }
}