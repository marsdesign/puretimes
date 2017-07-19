<?php   
class Bootstrap_Girls_Block_Index extends Mage_Core_Block_Template{   

    public function __construct() {
        parent::__construct();
        //programmatically set template instead of xml
        //$this->setTemplate('bootstrap/ambassadors/city/view.phtml');
    }

   	public function getItems()
	{
      	$pathInfo = $this->getRequest()->getOriginalPathInfo();
        // Extract the requested key (whatever)
        $pathArray = explode('/girls/',$pathInfo);

        if(count($pathArray)>1){
       		$requestedKey = str_replace('/','',$pathArray[1]);
        }
        // todo factor in store id
        //$_storeId = Mage::app()->getStore()->getStoreId();
    	$girls = Mage::getModel('girls/girls')->getCollection()
                ->addFieldToFilter('active', 1)
				->setOrder('sort_order', 'ASC');

    	return $girls;
	}

}