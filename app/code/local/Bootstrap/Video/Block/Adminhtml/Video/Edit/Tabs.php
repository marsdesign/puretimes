<?php
  class Bootstrap_Video_Block_Adminhtml_Video_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
  {
     public function __construct()
     {
          parent::__construct();
          $this->setId('video_tabs');
          $this->setDestElementId('edit_form');
          $this->setTitle('Video Item');
      }
	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
                   'label' => 'Information',
                   'title' => 'Information',
                   'content' => $this->getLayout()
     				->createBlock('video/adminhtml_video_edit_tab_form')->toHtml()
		));
		/*
		$this->addTab('form_section', array(
                   'label' => 'Images',
                   'title' => 'Images',
                   'content' => $this->getLayout()
     				->createBlock('video/adminhtml_video_edit_tab_form')->toHtml()
		));
		*/
		return parent::_beforeToHtml();
	}
}