<?php
class Bootstrap_Faq_Block_Adminhtml_Faq_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    
    protected function _prepareLayout()
    {
        $return = parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        return $return;
    }
    
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('faq_form', array(
            'legend' => 'Information'
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name' => 'stores[]',
                'label' => $this->__('Store View'),
                'title' => $this->__('Store View'),
                'required' => true,
                'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'value' => Mage::app()->getStore(true)->getId(),
            ));
        }

        $fieldset->addField('question', 'text', array(
            'label' => 'Question',
            'class' => 'required-entry',
            'required' => true,
            'name' => 'question'
        ));
        $fieldset->addField('answer', 'editor',
                        array(
                            'label' => 'Answer',
                            'required' => true,
                            'name' => 'answer',
                            'title' => 'Answer',
                            'style' => 'height:12em;',
                            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
                        )); 
        $fieldset->addField('sort_order', 'text',
            array(
              'label' => 'Sort Order',
              'name' => 'sort_order',
            ));
        $fieldset->addField('active', 'select',
            array(
                'label' => 'Enabled?',
                'class' => 'required-entry',
                'required' => true,
                'name' => 'active',
                        'values' => array(
                                array(
                                    'value'     => 0,
                                    'label'     => 'Disabled',
                                ),
                                array(
                                    'value'     => 1,
                                    'label'     => 'Enabled',
                                ), 
                        ),
        ));
        if (Mage::registry('faq_data')) {
            $form->setValues(Mage::registry('faq_data')->getData());
        }
        return parent::_prepareForm();
    }
}