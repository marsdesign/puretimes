<?php
class Vh_Assistant_Block_Adminhtml_Poll_Answer_Edit_Form extends Mage_Adminhtml_Block_Poll_Answer_Edit_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('edit_answer_form', array('legend' => Mage::helper('poll')->__('Edit Poll Answer')));

        $fieldset->addField('answer_title', 'text', array(
                    'name'      => 'answer_title',
                    'title'     => Mage::helper('poll')->__('Answer Title'),
                    'label'     => Mage::helper('poll')->__('Answer Title'),
                    'required'  => true,
                    'class'     => 'required-entry',
                )
        );

        $fieldset->addField('votes_count', 'text', array(
                    'name'      => 'votes_count',
                    'title'     => Mage::helper('poll')->__('Votes Count'),
                    'label'     => Mage::helper('poll')->__('Votes Count'),
                    'class'     => 'validate-not-negative-number'
                )
        );
        $fieldset->addField('answer_status', 'select',
            array(
                'label' => 'Status',
                //'class' => 'required-entry',
                //'required' => true,
                'name' => 'answer_status',
                        'values' => array(
                                array(
                                    'value'     => 0,
                                    'label'     => 'Pending',
                                ),
                                array(
                                    'value'     => 1,
                                    'label'     => 'Approved',
                                ), 
                        ),
        ));

        $fieldset->addField('poll_id', 'hidden', array(
                    'name'      => 'poll_id',
                    'no_span'   => true,
                )
        );

        $form->setValues(Mage::registry('answer_data')->getData());
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setMethod('post');
        $form->setAction($this->getUrl('*/*/save', array('id' => Mage::registry('answer_data')->getAnswerId())));
        $this->setForm($form);
    }
}
