<?php
class Vh_Assistant_Block_Adminhtml_Poll_Edit_Tab_Form extends Mage_Adminhtml_Block_Poll_Edit_Tab_Form
{
    protected function _toHtml()
    {
        //$form = new Varien_Data_Form();
		$form = $this->getForm();
		$fieldset = $form->getElement('poll_form');
		try{
			if( Mage::getSingleton('adminhtml/session')->getPollData() ) {
				$form->setValues(Mage::getSingleton('adminhtml/session')->getPollData());
				Mage::getSingleton('adminhtml/session')->setPollData(null);
			} elseif( Mage::registry('poll_data') ) {
				$form->setValues(Mage::registry('poll_data')->getData());
	
				if( Mage::registry('poll_data')->getPollType() == 1 ){

					$fieldset->removeField('poll_title');

					$fieldset->addField('poll_title', 'hidden', array(
						'name'      => 'poll_title',
						'no_span'   => true,
						'value'     => Mage::registry('poll_data')->getPollTitle()
					));
		
					$fieldset->addField('poll_type', 'hidden', array(
						'name'      => 'poll_type',
						'no_span'   => true,
						'value'     => Mage::registry('poll_data')->getPollType()
					));
					$fieldset->addField('alt_poll_title', 'text', array(
						'name'               => 'alt_poll_title',
						'label'              => Mage::helper('poll')->__('Poll Title'),
						'tabindex'           => 1,
						'value'              =>  trim((string)Mage::registry('poll_data')->getAltPollTitle())==''?'Untitled':Mage::registry('poll_data')->getAltPollTitle()
					));
					$fieldset->addField('start_date', 'date', array(
						'name'               => 'start_date',
						'label'              => Mage::helper('poll')->__('Start Date'),
						'after_element_html' => '<small>Comments</small>',
						'tabindex'           => 1,
						'image'              => $this->getSkinUrl('images/grid-cal.gif'),
						'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
						'value'              =>  Mage::registry('poll_data')->getStartDate()
					));
					$fieldset->addField('end_date', 'date', array(
						'name'               => 'end_date',
						'label'              => Mage::helper('poll')->__('End Date'),
						'after_element_html' => '<small>Comments</small>',
						'tabindex'           => 1,
						'image'              => $this->getSkinUrl('images/grid-cal.gif'),
						'format'             => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT) ,
						'value'              =>  Mage::registry('poll_data')->getEndDate()
					));
					//echo '<pre>'.print_r($fieldset,true).'</pre>';
					//die;
				}else{
					$fieldset->addField('alt_poll_title', 'hidden', array(
						'name'      => 'alt_poll_title',
						'no_span'   => true,
						'value'     => Mage::registry('poll_data')->getAltPollTitle()
					));
					$fieldset->addField('poll_type', 'hidden', array(
						'name'      => 'poll_type',
						'no_span'   => true,
						'value'     => Mage::registry('poll_data')->getPollType()
					));
				}
			}
			$this->setForm($form);
		}
		catch (Exception $e) {
			die($e->getMessage());
			/*
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_initLayoutMessages('adminhtml/session');
				$response->setError(true);
				$response->setMessage($this->getLayout()->getMessagesBlock()->getGroupedHtml());
			*/	
		}

		return parent::_toHtml();
		//return parent::_prepareForm();
	}	
}
