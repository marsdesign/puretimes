<?php
class Bootstrap_Video_Block_Adminhtml_Video_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
   public function __construct()
   {
       parent::__construct();
       $this->setId('videoGrid');
       $this->setDefaultSort('video_id');
       $this->setDefaultDir('ASC');
       $this->setSaveParametersInSession(true);
   }
   protected function _prepareCollection()
   {
      $collection = Mage::getModel('video/video')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
	}
   protected function _prepareColumns()
   {
       $this->addColumn('video_id',
             array(
                    'header' => 'ID',
                    'align' =>'right',
                    'width' => '50px',
                    'index' => 'video_id',
               ));
       $this->addColumn('title',
               array(
                    'header' => 'Title',
                    'align' =>'left',
                    'index' => 'title',
              ));
      if ( !Mage::app()->isSingleStoreMode() ) {
          $this->addColumn('store_id', array(
              'header' => 'Store View',
              'index' => 'store_id',
              'type' => 'store',
              'store_all' => true,
              'store_view' => true,
              'sortable' => true,
              'filter_condition_callback' => array($this, '_filterStoreCondition'),
          ));
      }
      $this->addColumn('sort_order', array(
                    'header' => 'Sort Order',
                    'align' =>'left',
                    'index' => 'sort_order',
             ));
      $this->addColumn('active', array(
                'header' => 'Active',
                'align' =>'left',
                'index' => 'active',
         ));
         return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
         return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}