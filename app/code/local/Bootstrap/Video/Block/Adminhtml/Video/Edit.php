<?php
class Bootstrap_Video_Block_Adminhtml_Video_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
   public function __construct()
   {
        parent::__construct();
        $this->_objectId = 'video_id'; // or should be just id?
        //vwe assign the same blockGroup as the Grid Container
        $this->_blockGroup = 'video';
        //and the same controller
        $this->_controller = 'adminhtml_video';
        //define the label for the save and delete button
        $this->_updateButton('save', 'label','save');
        $this->_updateButton('delete', 'label', 'delete');
    }
       /* Here, we're looking if we have transmitted a form object,
          to update the good text in the header of the page (edit or add) */
    public function getHeaderText()
    {
        if( Mage::registry('video_data')&&Mage::registry('video_data')->getId())
         {
              return 'Edit Video '.$this->htmlEscape(
              Mage::registry('video_data')->getTitle()).'<br />';
         }
         else
         {
             return 'Add Video Item';
         }
    }
}