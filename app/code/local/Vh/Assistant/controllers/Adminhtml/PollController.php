<?php
require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'PollController.php');
 
class Vh_Assistant_Adminhtml_PollController extends Mage_Adminhtml_PollController
{

    public function indexAction()
    {
		if(Mage::getSingleton('core/session')->getTheReferrer() == 1){
			Mage::getSingleton('core/session')->setTheReferrer(999);
		}else{
			Mage::getSingleton('core/session')->setThePollType(0);
			Mage::getSingleton('core/session')->setTheReferrer(0);
		}

        $this->_title($this->__('CMS'))->_title($this->__('Polls'));
        $this->loadLayout();
        $this->_setActiveMenu('cms/poll');
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Poll Manager'), Mage::helper('adminhtml')->__('Poll Manager'));

        $this->_addContent($this->getLayout()->createBlock('adminhtml/poll_poll'));
        $this->renderLayout();
    }
    public function stylesAction()
    {
        $collection = Mage::getModel('poll/poll')
		->getCollection();

		foreach($collection as $p){
			$the_poll = Mage::getModel('poll/poll')->load($p->getPollId());
			if(trim((string)$the_poll->getAltPollTitle())==''){
				$the_poll->setAltPollTitle('Untitled');
				$the_poll->save();
			}
		}
		
		Mage::getSingleton('core/session')->setThePollType(1);
		Mage::getSingleton('core/session')->setTheReferrer(999);

        $this->_title($this->__('CMS'))->_title($this->__('VH Polls'));
        $this->loadLayout();
        $this->_setActiveMenu('cms/poll');
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Poll Manager'), Mage::helper('adminhtml')->__('Poll Manager'));

        $this->_addContent($this->getLayout()->createBlock('adminhtml/poll_poll'));
        $this->renderLayout();

    }

    public function editAction()
    {
		Mage::getSingleton('core/session')->setTheReferrer(Mage::getSingleton('core/session')->getThePollType());
		
        $this->_title($this->__('CMS'))->_title($this->__('Polls'));

        $pollId     = $this->getRequest()->getParam('id');
        $pollType   = 	Mage::getSingleton('core/session')->getThePollType();
        $pollModel  = Mage::getModel('poll/poll')->load($pollId);
		
		$pollModel->setPollType($pollType);
		
        if ($pollModel->getId() || $pollId == 0) {
            $this->_title($pollModel->getId() ? $pollModel->getPollTitle() : $this->__('New Poll'));

            Mage::register('poll_data', $pollModel);

            $this->loadLayout();
            $this->_setActiveMenu('cms/poll');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Poll Manager'), Mage::helper('adminhtml')->__('Poll Manager'), $this->getUrl('*/*/'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Edit Poll'), Mage::helper('adminhtml')->__('Edit Poll'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('adminhtml/poll_edit'))
                ->_addLeft($this->getLayout()->createBlock('adminhtml/poll_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('poll')->__('The poll does not exist.'));
            $this->_redirect('*/*/');
        }
    }

    public function deleteAction()
    {
		Mage::getSingleton('core/session')->setTheReferrer(Mage::getSingleton('core/session')->getThePollType());

        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('poll/poll');
                $model->setId($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The poll has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find a poll to delete.'));
        $this->_redirect('*/*/');
    }

    public function saveAction()
    {
		Mage::getSingleton('core/session')->setTheReferrer(Mage::getSingleton('core/session')->getThePollType());
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The poll has been saved.'));
        Mage::getSingleton('adminhtml/session')->setPollData(false);
        $this->_redirect('*/*/');
    }

    public function newAction()
    {
		Mage::getSingleton('core/session')->setTheReferrer(Mage::getSingleton('core/session')->getThePollType());

        $this->getRequest()->setParam('id', 0);
		
        if(Mage::getSingleton('core/session')->getThePollType() == 1){


            try {
					$pollModel = Mage::getModel('poll/poll');
					$pollModel->setDatePosted(now());
					$pollModel->setDateClosed(new Zend_Db_Expr('null'));
					$pollModel->setPollTitle(time());
					$pollModel->setPollType(1)
					->setClosed(0);
	
					//$pollModel->setStoreIds($storeIds);
					$answerModel = Mage::getModel('poll/poll_answer');
					$answerModel->setAnswerTitle('dummy item only')
						->setAnswerStatus(0)
						->setVotesCount(0);
					$pollModel->addAnswer($answerModel);
					$pollModel->save();		
					$this->getRequest()->setParam('id', $pollModel->getId());
            }
            catch (Exception $e) {
                //die($e->getMessage());
            }
		}
        $this->_forward('edit');
    }

    public function validateAction()
    {
		Mage::getSingleton('core/session')->setTheReferrer(Mage::getSingleton('core/session')->getThePollType());

        $response = new Varien_Object();
        $response->setError(false);

        if ( $this->getRequest()->getPost() ) {
            try {
                $pollModel = Mage::getModel('poll/poll');

                if( !$this->getRequest()->getParam('id') ) {
                    $pollModel->setDatePosted(now());
                }

                if( $this->getRequest()->getParam('closed') && !$this->getRequest()->getParam('was_closed') ) {
                    $pollModel->setDateClosed(now());
                }

                if( !$this->getRequest()->getParam('closed') ) {
                    $pollModel->setDateClosed(new Zend_Db_Expr('null'));
                }

                $pollModel->setPollTitle($this->getRequest()->getParam('poll_title'))
                      ->setClosed($this->getRequest()->getParam('closed'));

                if( $this->getRequest()->getParam('id') > 0 ) {
                    $pollModel->setId($this->getRequest()->getParam('id'));
                }

                $stores = $this->getRequest()->getParam('store_ids');
                if (!is_array($stores) || count($stores) == 0) {
                    Mage::throwException(Mage::helper('adminhtml')->__('Please, select "Visible in Stores" for this poll first.'));
                }

                if (is_array($stores)) {
                    $storeIds = array();
                    foreach ($stores as $storeIdList) {
                        $storeIdList = explode(',', $storeIdList);
                        if(!$storeIdList) {
                            continue;
                        }
                        foreach($storeIdList as $storeId) {
                            if( $storeId > 0 ) {
                                $storeIds[] = $storeId;
                            }
                        }
                    }
                    if (count($storeIds) === 0) {
                        Mage::throwException(Mage::helper('adminhtml')->__('Please, select "Visible in Stores" for this poll first.'));
                    }
                    $pollModel->setStoreIds($storeIds);
                }

                $answers = $this->getRequest()->getParam('answer');

                if( !is_array($answers) || sizeof($answers) == 0 ) {
                    Mage::throwException(Mage::helper('adminhtml')->__('Please, add some answers to this poll first.'));
                }

                if( is_array($answers) ) {
                    $_titles = array();
                    foreach( $answers as $key => $answer ) {
                        if( in_array($answer['title'], $_titles) ) {
                            Mage::throwException(Mage::helper('adminhtml')->__('Your answers contain duplicates.'));
                        }
                        $_titles[] = $answer['title'];

                        $answerModel = Mage::getModel('poll/poll_answer');
                        if( intval($key) > 0 ) {
                            $answerModel->setId($key);
                        }
                        $answerModel->setAnswerTitle($answer['title'])
                            ->setVotesCount($answer['votes']);

                        $pollModel->addAnswer($answerModel);
                    }
                }

                $pollModel->save();

                Mage::register('current_poll_model', $pollModel);

                $answersDelete = $this->getRequest()->getParam('deleteAnswer');
                if( is_array($answersDelete) ) {
                    foreach( $answersDelete as $answer ) {
                        $answerModel = Mage::getModel('poll/poll_answer');
                        $answerModel->setId($answer)
                            ->delete();
                    }
                }
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_initLayoutMessages('adminhtml/session');
                $response->setError(true);
                $response->setMessage($this->getLayout()->getMessagesBlock()->getGroupedHtml());
            }
        }
        $this->getResponse()->setBody($response->toJson());
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/poll');
    }
}
