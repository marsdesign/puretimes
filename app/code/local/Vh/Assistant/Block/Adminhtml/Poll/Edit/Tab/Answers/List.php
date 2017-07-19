<?php
class Vh_Assistant_Block_Adminhtml_Poll_Edit_Tab_Answers_List extends Mage_Adminhtml_Block_Poll_Edit_Tab_Answers_List
{
    public function __construct()
    {
        //$this->setTemplate('poll/answers/list.phtml');
        $this->setTemplate('vh/assistant/poll/answers/list.phtml');
    }

    protected function _toHtml()
    {
        if( !Mage::registry('poll_data') ) {
            $this->assign('answers', false);
            return parent::_toHtml();
        }

        $collection = Mage::getModel('poll/poll_answer')
            ->getResourceCollection()
            ->addPollFilter(Mage::registry('poll_data')->getId())
            ->load();
        $this->assign('answers', $collection);
        $this->assign('the_poll_id', Mage::registry('poll_data')->getId());
        $this->assign('is_new_poll', Mage::getSingleton('core/session')->getIsNewPoll());
		Mage::getSingleton('core/session')->setIsNewPoll(0);
        return parent::_toHtml();
    }

    protected function _prepareLayout()
    {
        $this->setChild('deleteButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('poll')->__('Delete'),
                    'onclick'   => 'answer.del(this)',
                    'class' => 'delete'
                ))
        );

        $this->setChild('addButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('poll')->__('Add New Answer'),
                    'onclick'   => 'answer.add(this)',
                    'class' => 'add'
                ))
        );
        return parent::_prepareLayout();
    }

    public function getDeleteButtonHtml()
    {
        return $this->getChildHtml('deleteButton');
    }

    public function getAddButtonHtml()
    {
        return $this->getChildHtml('addButton');
    }
}
