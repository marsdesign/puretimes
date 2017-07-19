<?php
class Bootstrap_Hero_IndexController extends Mage_Core_Controller_Front_Action{
    public function indexAction() {    
		$this->loadLayout();
    	$this->renderLayout();
    }
	public function listAction ()
	{
     	echo 'test list method';
    	$params = $this->getRequest()->getParams();
    	$hero = Mage::getModel('hero/hero');
    	echo("Loading the hero with an ID of ".$params['id']);
    	$hero->load($params['id']);
    	$data = $hero->getData();
    	var_dump($data);
    }

}
