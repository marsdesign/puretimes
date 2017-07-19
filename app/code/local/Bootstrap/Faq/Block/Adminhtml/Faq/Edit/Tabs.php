<?php
  class Bootstrap_Faq_Block_Adminhtml_Faq_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
  {
     public function __construct()
     {
          parent::__construct();
          $this->setId('faq_tabs');
          $this->setDestElementId('edit_form');
          $this->setTitle('FAQ Item');
      }
	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
                   'label' => 'Information',
                   'title' => 'Information',
                   'content' => $this->getLayout()
     				->createBlock('faq/adminhtml_faq_edit_tab_form')->toHtml()
		));
		/*
		$this->addTab('form_section', array(
                   'label' => 'Images',
                   'title' => 'Images',
                   'content' => $this->getLayout()
     				->createBlock('faq/adminhtml_faq_edit_tab_form')->toHtml()
		));
		*/
		return parent::_beforeToHtml();
	}
}