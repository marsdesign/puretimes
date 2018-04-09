<?php
class Bootstrap_Girls_Block_Adminhtml_Girls_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
   public function __construct()
   {
        parent::__construct();
        $this->_objectId = 'girls_id'; // or should be just id?
        //vwe assign the same blockGroup as the Grid Container
        $this->_blockGroup = 'girls';
        //and the same controller
        $this->_controller = 'adminhtml_girls';
        //define the label for the save and delete button
        $this->_updateButton('save', 'label','save');
        $this->_updateButton('delete', 'label', 'delete');
    }
       /* Here, we're looking if we have transmitted a form object,
          to update the good text in the header of the page (edit or add) */
    public function getHeaderText()
    {
        if( Mage::registry('girls_data')&&Mage::registry('girls_data')->getId())
         {
              return 'Edit Item '.$this->htmlEscape(
              Mage::registry('girls_data')->getTitle()).'<br />';
         }
         else
         {
             return 'Add Item';
         }
    }
}