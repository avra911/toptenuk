<?php

class MagenThemes_MTColinusAdmin_SupportController extends Mage_Adminhtml_Controller_Action
{ 
	public function indexAction()
	{
        $url = 'http://support.9magentothemes.com/open.php';
        $this->getResponse()->setRedirect($url);
	} 
} 
?>
