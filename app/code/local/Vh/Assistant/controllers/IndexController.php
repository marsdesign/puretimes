<?php
class Vh_Assistant_IndexController extends Mage_Core_Controller_Front_Action{
    public function indexAction() {   
		$this->loadLayout();
    	$this->renderLayout();
    }
	public function saveAction() {
		$path = Mage::getBaseDir('media') . DS . 'vote-assistant' . DS .$this->getRequest()->getParam('poll_id') . DS;
		if (!file_exists($path)) {
			mkdir($path);
		}
		try {
			$fname = $_FILES['bs_image']['name'];
			$uploader = new Varien_File_Uploader('bs_image');
			$uploader->setAllowedExtensions(array('png','gif','jpg','jpeg'));
			$uploader->setAllowCreateFolders(true);
			$uploader->setAllowRenameFiles(false);
			$uploader->setFilesDispersion(false);
			$uploader->save($path, $fname);
		} catch (Exception $e) {
			echo 'Error Message: ' . $e->getMessage();
			die;
		}
		 if ( $this->getRequest()->getPost() ){
		 }
		try{
			$poll_id = $this->getRequest()->getParam('poll_id');
			$poll_answer = Mage::getModel('poll/poll_answer');
			$poll_answer->setPollId($poll_id);
			$path_parts = pathinfo($path.$fname);
			$cid = (int)$this->getRequest()->getPost('cid');
			$poll_answer->setCid($cid);
			$poll_answer->save();
			copy($path.$fname,$path.$poll_answer->getAnswerId().'.'.$path_parts['extension']);
			unlink($path.$fname);
			$poll_answer->setAnswerTitle($poll_answer->getAnswerId().'.'.$path_parts['extension']);
			$poll_answer->save();
			$message = '<p style="max-width:400px;margin:0 auto;font-size:16px">Your image has been successfully uploaded for moderation.</p>';
		} catch (Exception $e) {
			echo 'Error Message: ' . $e->getMessage();
			die;
		}
		Mage::getSingleton('core/session')->addNotice($message);
		Mage::getSingleton('core/session')->setScrollTop($this->getRequest()->getParam('scrolltop'));
		Mage::getSingleton('core/session')->setReferredBack(1);
		$this->_redirectReferer();
	}
    public function voteAction()
    {
        $pollId     = intval($this->getRequest()->getParam('poll_id'));
        $answerId   = intval($this->getRequest()->getParam('vote'));

        $poll = Mage::getModel('poll/poll')->load($pollId);

        if ($poll->getId() && !$poll->getClosed() && !$poll->isVoted()) {
            $vote = Mage::getModel('poll/poll_vote')
                ->setPollAnswerId($answerId)
                ->setIpAddress(Mage::helper('core/http')->getRemoteAddr(true))
                ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId());

            $poll->addVote($vote);
            Mage::getSingleton('core/session')->setJustVotedPoll($pollId);

			Mage::getSingleton('core/session')->addSuccess('Thank you for voting!'); 

            Mage::dispatchEvent(
                'poll_vote_add',
                array(
                    'poll'  => $poll,
                    'vote'  => $vote
                )
            );
        }else{
			if($poll->isVoted()){
				Mage::getSingleton('core/session')->addNotice('Sorry. '.Mage::helper('core/http')->getRemoteAddr(false).' already voted for this.');
			}
			elseif($poll->getClosed()){
				Mage::getSingleton('core/session')->addNotice('Sorry. This Poll is already closed.');
			}else{
				Mage::getSingleton('core/session')->addError('Sorry. Your request in invalid.');
			}
		}
        $this->_redirectReferer();
    }
}
