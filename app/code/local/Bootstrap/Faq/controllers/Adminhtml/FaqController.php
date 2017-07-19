<?php
class Bootstrap_Faq_Adminhtml_FaqController extends Mage_Adminhtml_Controller_Action{

	public function indexAction()
	{
		$this->_initAction();
		$this->loadLayout();
		$this->renderLayout();
		//echo '<pre>';
		//var_dump(Mage::getSingleton('core/layout')->getUpdate()->getHandles());
		//echo '</pre>';
		//exit("bailing early at ".__LINE__." in ".__FILE__);
	}  
     
    public function newAction()
    {  
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }  
     
    public function editAction()
    {  
		$id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('faq/faq')->load($id);
        if ($model->getId() || $id == 0)
        {
			Mage::register('faq_data', $model);
            $this->loadLayout();
        	$this->_setActiveMenu('cms/faq');
            $this->_addBreadcrumb('FAQ Manager', 'FAQ Manager');
            $this->_addBreadcrumb('FAQ Description', 'FAQ Description');
            $this->getLayout()->getBlock('head')
					->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()
					->createBlock('faq/adminhtml_faq_edit'))
					->_addLeft($this->getLayout()
					->createBlock('faq/adminhtml_faq_edit_tabs')
			);
			$this->renderLayout();
		}else{
			Mage::getSingleton('adminhtml/session')
				->addError('FAQ does not exist');
				$this->_redirect('*/*/');
		}         
    }
         
    public function saveAction()
    {

		if ($this->getRequest()->getPost())
        {
        	try {
				$postData = $this->getRequest()->getPost();
								
				// save to db
                $model = Mage::getModel('faq/faq');
               	if( $this->getRequest()->getParam('id') <= 0 )             	
                  	$model->setCreatedTime(Mage::getSingleton('core/date')->gmtDate());
                  	$model->addData($postData)->setUpdateTime(Mage::getSingleton('core/date')->gmtDate())
                    ->setId($this->getRequest()->getParam('id'))
                    ->save();
        			Mage::getSingleton('adminhtml/session')->addSuccess('Successfully saved');
                 	Mage::getSingleton('adminhtml/session')->setFaqData(false);
                 	$this->_redirect('*/*/');
                	return;
          	} catch (Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->settestData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit',array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
  
          
	public function deleteAction()
    {
    	if($this->getRequest()->getParam('id') > 0)
        {
        	try
            {
        		$model = Mage::getModel('faq/faq');
				$model->setId($this->getRequest()->getParam('id'))->delete();
				
				//$path = Mage::getBaseDir("media") . DS . $filename_from _db;
				//unlink($path);				
				
				
				Mage::getSingleton('adminhtml/session')->addSuccess('Successfully deleted');
				$this->_redirect('*/*/');
			}
			catch (Exception $e)
            {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}
     
    public function messageAction()
    {
        $data = Mage::getModel('faq/faq')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }
     
    /**
     * Initialize action
     *
     * Here, we set the breadcrumbs and the active menu
     *
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('cms/faq')->_addBreadcrumb('Faq Manager','Faq Manager');
		return $this;
	}
     
    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/faq');
    }

}
