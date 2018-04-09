<?php
  class Bootstrap_Girls_Block_Adminhtml_Girls_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
  {
     public function __construct()
     {
          parent::__construct();
          $this->setId('girls_tabs');
          $this->setDestElementId('edit_form');
          $this->setTitle('Lookbook Girl');
      }
	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
                   'label' => 'Information',
                   'title' => 'Information',
                   'content' => $this->getLayout()
     				->createBlock('girls/adminhtml_girls_edit_tab_form')->toHtml()
		));
		/*
		$this->addTab('form_section', array(
                   'label' => 'Images',
                   'title' => 'Images',
                   'content' => $this->getLayout()
     				->createBlock('girls/adminhtml_girls_edit_tab_form')->toHtml()
		));
		*/
		return parent::_beforeToHtml();
	}
}