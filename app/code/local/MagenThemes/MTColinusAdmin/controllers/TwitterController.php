<?php
/*------------------------------------------------------------------------

 # ArexMage

# ------------------------------------------------------------------------

# Copyright (C) 2013 ArexMage. All Rights



Reserved.

# @license - Copyrighted Commercial Software

# Author: ArexMage

# Websites: http://www.arexmage.com

-------------------------------------------------------------------------*/

class MagenThemes_MTColinusAdmin_TwitterController extends Mage_Core_Controller_Front_Action {

    public function getTwitterApi()
    {
        return Mage::getSingleton('mtcolinusadmin/config_twitterapi');
    }
	public function indexAction()
    {
        $config = Mage::getStoreConfig('mtcolinusadmin/social_config');
        $_consumer_key = $config['twitter_consumer_key'];
        $_consumer_secret = $config['twitter_consumer_secret'];
        $_access_token = $config['twitter_access_token'];
        $_access_token_secret = $config['twitter_access_token_secret'];

        $this->getTwitterApi()->setConsumerKey($_consumer_key, $_consumer_secret);
        $cb = $this->getTwitterApi()->getInstance();
        $cb->setToken($_access_token, $_access_token_secret);
        $user  = $this->getRequest()->getParam('user', false);
        $count = $this->getRequest()->getParam('count', false);
        $api   = $this->getRequest()->getParam('api', false);
        $params = array(
            'screen_name' => $user,
            'user' => $user,
            'count' => $count
        );
        if($user){
        	$data = (array) $cb->$api($params);
        	echo Mage::helper('core')->jsonEncode($data);
        }else{
        	$data = $this->__('Please insert your Twitter account');
        	echo Mage::helper('core')->jsonEncode($data);
        } 
    }
}

