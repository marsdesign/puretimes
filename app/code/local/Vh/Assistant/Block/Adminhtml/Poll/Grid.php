<?php
class Vh_Assistant_Block_Adminhtml_Poll_Grid extends Mage_Adminhtml_Block_Poll_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('pollGrid');
        $this->setDefaultSort('poll_title');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('poll/poll')
		->getCollection();
				
		$collection->addFieldToFilter('poll_type', Mage::getSingleton('core/session')->getThePollType());
		
        $this->setCollection($collection);
        //parent::_prepareCollection();

        if (!Mage::app()->isSingleStoreMode()) {
            $this->getCollection()->addStoreData();
        }

        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('poll_id', array(
            'header'    => Mage::helper('poll')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'poll_id',
        ));
		if(Mage::getSingleton('core/session')->getThePollType() == 1){
			$this->addColumn('alt_poll_title', array(
				'header'    => Mage::helper('poll')->__('Poll Title'),
				'align'     =>'left',
				'index'     => 'alt_poll_title',
			));
		}else{
			$this->addColumn('poll_title', array(
				'header'    => Mage::helper('poll')->__('Poll Question'),
				'align'     =>'left',
				'index'     => 'poll_title',
			));
		}

        $this->addColumn('votes_count', array(
            'header'    => Mage::helper('poll')->__('Number of Responses'),
            'width'     => '50px',
            'type'      => 'number',
            'index'     => 'votes_count',
        ));

        $this->addColumn('date_posted', array(
            'header'    => Mage::helper('poll')->__('Date Posted'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'datetime',
            'index'     => 'date_posted',
            'format'	=> Mage::app()->getLocale()->getDateFormat()
        ));

        $this->addColumn('date_closed', array(
            'header'    => Mage::helper('poll')->__('Date Closed'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'datetime',
            'default'   => '--',
            'index'     => 'date_closed',
            'format'	=> Mage::app()->getLocale()->getDateFormat()
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('visible_in', array(
                'header'    => Mage::helper('review')->__('Visible In'),
                'index'     => 'stores',
                'type'      => 'store',
                'store_view' => true,
                'sortable'   => false,
            ));
        }

        /*
        $this->addColumn('active', array(
            'header'    => Mage::helper('poll')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'active',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));
        */
        $this->addColumn('closed', array(
            'header'    => Mage::helper('poll')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'closed',
            'type'      => 'options',
            'options'   => array(
                1 => Mage::helper('poll')->__('Closed'),
                0 => Mage::helper('poll')->__('Open')
            ),
        ));

        return parent::_toHtml();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
