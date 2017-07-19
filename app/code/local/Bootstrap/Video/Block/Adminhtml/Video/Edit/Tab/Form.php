<?php
class Bootstrap_Video_Block_Adminhtml_Video_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
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
        $fieldset = $form->addFieldset('video_form', array(
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

        $fieldset->addField('title', 'text', array(
            'label' => 'Title',
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title'
        ));
        $fieldset->addField('video', 'text',
                        array(
                            'label' => 'Video Url',
                            'required' => false,
                            'name' => 'video',
                        ));
        $fieldset->addField('description', 'editor',
                        array(
                            'label' => 'Description',
                            'required' => false,
                            'name' => 'description',
                            'title' => 'Description',
                            'style' => 'height:12em;',
                            'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
                        )); 
        $fieldset->addField('image', 'image', 
          array(
            'label'     => 'Image',
            'class' => 'required-entry',
            'required'  => true,
            'name'      => 'image',
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
        $fieldset->addField('featured', 'select',
            array(
                  'label' => 'Featured?',
                  'class' => 'required-entry',
                  'required' => false,
                  'name' => 'featured',
                  'values' => array(
                          array(
                              'value'     => 0,
                              'label'     => 'No',
                          ),
                          array(
                              'value'     => 1,
                              'label'     => 'Yes',
                          ), 
                  ),
        ));
		$collection_of_products = Mage::getModel('catalog/product')
        ->getCollection();
		$collection_of_products->addAttributeToSelect('name');
		$collection_of_products->setOrder('name', 'ASC');
		$product_values = array();

		$product_values[] =  array(
						  'value'     => '0',
						  'label'     => ''
					  );
		
		foreach($collection_of_products as $p){
			$product_values[] =  array(
                              'value'     => $p->getId(),
                              'label'     => $p->getName()
                          );
		}
        $fieldset->addField('product_id', 'select',
            array(
                  'label' => 'Related Product',
                  'class' => 'required-entry',
                  'required' => false,
                  'name' => 'product_id',
                  'values' => $product_values,
        ));
		
        $fieldset->addField('type_id', 'select',
            array(
                  'label' => 'Type',
                  'class' => 'required-entry',
                  'required' => false,
                  'name' => 'type_id',
                  'values' => array(
                          array(
                              'value'     => '0',
                              'label'     => '',
                          ), 
                          array(
                              'value'     => '1',
                              'label'     => 'Virgin Hair Secrets',
                          ), 
                          array(
                              'value'     => '2',
                              'label'     => 'Video Reviews',
                          ), 
                  ),
        ));
        if (Mage::registry('video_data')) {
            $form->setValues(Mage::registry('video_data')->getData());
        }
        return parent::_prepareForm();
    }
}