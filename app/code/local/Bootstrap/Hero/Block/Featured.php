<?php   
class Bootstrap_Hero_Block_Featured extends Mage_Core_Block_Template{   

    public function __construct() {
        parent::__construct();
        //programmatically set template instead of xml
        //$this->setTemplate('bootstrap/ambassadors/city/view.phtml');
    }

   	public function getItems()
	{

        // todo factor in store id
        //$_storeId = Mage::app()->getStore()->getStoreId();
        $featured = Mage::getModel('hero/hero')->getCollection()
                ->addFieldToFilter('active', 1)
                ->addFieldToFilter('featured', 1)
                ->setOrder('sort_order', 'ASC');
        return $featured;
	}

}


