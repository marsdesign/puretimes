<?php
class Vh_Assistant_Model_Observer extends Mage_Core_Model_Abstract
{
	public function validateVideoUrl($url){
		$pattern = '/(http:|https:)?\/\/(www\.)?(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/';
		preg_match($pattern, $url, $matches);
		if (count($matches))
		{
			return true;
		}
		$pattern = '/vimeo.*(?:\/|clip_id=)([0-9a-z]*)/';
		preg_match($pattern, $url, $matches);
		if (count($matches))
		{
			return true;
		}
		return false;
	}
    public function saveProductVideoReviewUrl(Varien_Event_Observer $observer)
    {
		$data = $observer->getEvent()->getControllerAction()->getRequest()->getParams();
		if(isset($data['videourl']) && trim($data['videourl']) != '' && $this->validateVideoUrl($data['videourl'])){
			$nickname = $data['nickname'];
			$title = $data['title'];
			$detail = $data['detail'];
			$videourl = $data['videourl'];
			$product_id = $data['id'];
			$form_key = $data['form_key'];
			$_product = Mage::getModel('catalog/product')->load($product_id); 
			$the_product = ''; 
			if($_product){
				$the_product = ' ('.$_product->getName().')';
			}
			$video_data = array(
				"form_key"=>$form_key,
				"stores"=>"",
				"title"=>"{$title} - Sent by {$nickname}",
				"video"=>$videourl,
				"description"=>$detail.'<p class="hidden-on-front"><em>Notes: Sent via Product Detail Page'.$the_product.'.</em></p>',
				"sort_order"=>"0",
				"active"=>"0",
				"featured"=>"0",
				"product_id"=>$product_id,
				"type_id"=>"2"
			);
				
			fwrite($file,json_encode($video_data)."\n");
			Mage::getSingleton('core/session')->setVideoReviewData($video_data);
		}else{
			Mage::getSingleton('core/session')->setVideoReviewData(false);
		}
		return true;
    }
	public function saveProductVideoReview(Varien_Event_Observer $observer){

		if(Mage::getSingleton('core/session')->getVideoReviewData()){

			$video_data = Mage::getSingleton('core/session')->getVideoReviewData();
			if(isset($video_data['video']) && trim($video_data['video']) != '' && $this->validateVideoUrl($video_data['video'])){
				try{
					 $model = Mage::getModel('video/video');
					 $model->setCreatedTime(Mage::getSingleton('core/date')->gmtDate());
					 $model->addData($video_data)->setUpdateTime(Mage::getSingleton('core/date')->gmtDate())
					->save();
				} catch (Exception $e){
				}
			}
		}
		Mage::getSingleton('core/session')->setVideoReviewData(false);
	}
    public function saveVirginHairPoll(Varien_Event_Observer $observer)
    {
		$data = $observer->getEvent()->getControllerAction()->getRequest()->getParams();
		$answers = $observer->getEvent()->getControllerAction()->getRequest()->getParam('answer');
		
		if( $observer->getEvent()->getControllerAction()->getRequest()->getParam('id') > 0 ) {
			$pollModel = Mage::getModel('poll/poll');
			$pollModel->setId($observer->getEvent()->getControllerAction()->getRequest()->getParam('id'));
			$pollModel->setPollType($observer->getEvent()->getControllerAction()->getRequest()->getParam('poll_type'));
			if($observer->getEvent()->getControllerAction()->getRequest()->getParam('start_date') != ''){
				$pollModel->setStartDate($observer->getEvent()->getControllerAction()->getRequest()->getParam('start_date'));
			}
			if($observer->getEvent()->getControllerAction()->getRequest()->getParam('end_date') != ''){
				$pollModel->setEndDate($observer->getEvent()->getControllerAction()->getRequest()->getParam('end_date'));
			}
			if($observer->getEvent()->getControllerAction()->getRequest()->getParam('alt_poll_title') != ''){
				$pollModel->setAltPollTitle($observer->getEvent()->getControllerAction()->getRequest()->getParam('alt_poll_title'));
			}
			$pollModel->save();
			$_titles = array();
			foreach( $answers as $key => $answer ) {
				if( in_array($answer['title'], $_titles) ) {
					//Mage::throwException(Mage::helper('adminhtml')->__('Your answers contain duplicates.'));
					//continue;
				}
				//$_titles[] = $answer['title'];
	
				$answerModel = Mage::getModel('poll/poll_answer');
				if( intval($key) > 0 ) {
					$answerModel->setId($key);
					$answerModel->setAnswerStatus($answer['status'])
						->save();
				}
			}
		}
		
		return true;
    }
    public function markNewPoll(Varien_Event_Observer $observer){
		Mage::getSingleton('core/session')->setIsNewPoll(1);
	}
    public function markLoginReferrer(Varien_Event_Observer $observer){
		$session = Mage::getSingleton('customer/session');
		/*
		if (stripos(Mage::helper('core/http')->getHttpReferer(), '/vote') === false){
			$session->setAfterAuthUrl(Mage::getBaseUrl());  
			Mage::getSingleton('core/session')->setVoteReferrer(0);
		}
		else{             
			$session->setAfterAuthUrl(Mage::helper('core/http')->getHttpReferer());
			Mage::getSingleton('core/session')->setVoteReferrer(1);
			//Mage::getSingleton('core/session')->addSuccess('You may now upload images.'); 
		}
		*/
		if (stripos(Mage::helper('core/http')->getHttpReferer(), '/howtovote') === false){
			//$session->setAfterAuthUrl(Mage::getBaseUrl());  
			$session->setAfterAuthUrl(Mage::helper('core/http')->getHttpReferer());
			Mage::getSingleton('core/session')->setVoteReferrer(0);
		}
		else{             
			$session->setAfterAuthUrl(Mage::getUrl('vote'));
			Mage::getSingleton('core/session')->setVoteReferrer(1);
		}
		$session->setBeforeAuthUrl('');
	}
    public function saveSettingsAfter(Varien_Event_Observer $observer)
    {

		$poll_id = Mage::getSingleton('core/session')->getTheSurveyId();
		$vote_id = Mage::getSingleton('core/session')->getTheVoteId();

		if($poll_id && $vote_id){
			$pollId = intval($poll_id);
			$answerId   = intval($vote_id);
			$poll = Mage::getModel('poll/poll')->load($pollId);
	
			if ($poll->getId() && !$poll->getClosed() && !$poll->isVoted()) {
				$vote = Mage::getModel('poll/poll_vote')
					->setPollAnswerId($answerId)
					->setIpAddress(Mage::helper('core/http')->getRemoteAddr(true))
					->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId());
	
				$poll->addVote($vote);
				Mage::getSingleton('core/session')->setJustVotedPoll($pollId);
				Mage::dispatchEvent(
					'poll_vote_add',
					array(
						'poll'  => $poll,
						'vote'  => $vote
					)
				);
			}
		}
		
		$will_subscribe = Mage::getSingleton('core/session')->getWillSubscribe();
		$order = $observer->getEvent()->getOrder();
		$email = (string)$order->getCustomerEmail();

		if($will_subscribe == 'on'){
            $session            = Mage::getSingleton('core/session');
            $customerSession    = Mage::getSingleton('customer/session');

            try {
                if (!Zend_Validate::is($email, 'EmailAddress')) {
                    //Mage::throwException($this->__('Please enter a valid email address.'));
					$file = fopen('errors.txt','a+');
					fwrite($file,"Invalid Email\n");
					fclose($file);
                }
                if (Mage::getStoreConfig(Mage_Newsletter_Model_Subscriber::XML_PATH_ALLOW_GUEST_SUBSCRIBE_FLAG) != 1 && 
                    !$customerSession->isLoggedIn()) {
                    //Mage::throwException($this->__('Sorry, but administrator denied subscription for guests. Please <a href="%s">register</a>.', Mage::helper('customer')->getRegisterUrl()));
					$file = fopen('errors.txt','a+');
					fwrite($file,"Denied (guest)\n");
					fclose($file);
                }
                $ownerId = Mage::getModel('customer/customer')
                        ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
                        ->loadByEmail($email)
                        ->getId();
                if ($ownerId !== null && $ownerId != $customerSession->getId()) {
                    //Mage::throwException($this->__('This email address is already assigned to another user.'));
					$file = fopen('errors.txt','a+');
					fwrite($file,$email." in use\n");
					fclose($file);
                }

					Mage::getModel('newsletter/subscriber')
						->setStoreId($order->getStoreId())
						->setSubscriberFirstname($order->getCustomerFirstname())
						->setSubscriberLastname($order->getCustomerLastname())
						->setEmail($order->getCustomerEmail())
						->subscribe($email);

                if ($status == Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE) {
                    $session->addSuccess(('Confirmation request has been sent.'));
                }
                else {
                    $session->addSuccess(('Thank you for your subscription.'));
                }
            }
            catch (Mage_Core_Exception $e) {
                    $session->addException($e, $this->__('There was a problem with the subscription: %s', $e->getMessage()));
					$file = fopen('errors.txt','a+');
					fwrite($file,$e->getMessage()."\n");
					fclose($file);
            }
            catch (Exception $e) {
					$file = fopen('errors.txt','a+');
					fwrite($file,$e->getMessage()."\n");
					fclose($file);
                    $session->addException($e, $this->__('There was a problem with the subscription.'));
            }
		}else{
		}
 		 
		return true;
    }
    public function saveSettingsBefore($observer)
    {
		if(isset($_POST['poll_id'])){
			 Mage::getSingleton('core/session')->setTheSurveyId(intval($_POST['poll_id']));
		}
		if(isset($_POST['vote'])){
			 Mage::getSingleton('core/session')->setTheVoteId(intval($_POST['vote']));
		}
		if(isset($_POST['will_subscribe']) || isset($_POST['poll_id']) ){
			 Mage::getSingleton('core/session')->setWillSubscribe($_POST['will_subscribe']);
		}
		return true;
    }
    public function redirectWithMessage($observer)
    {
		if(isset($_REQUEST['redirect_url'])){
			$url = $_REQUEST['redirect_url'];
			if(isset($_REQUEST['form_type']) && $_REQUEST['form_type'] == 'contact_form'){
				Mage::getSingleton('core/session')->addSuccess('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.');
				if(stripos($url,'contact') > 0){
				}else{
					Mage::getSingleton('customer/session')->getMessages(true);
				}
			}
			Mage::app()->getFrontController()->getResponse()->setRedirect($url);
		}
		return true;
    }
	
}