<?php

class Ophirah_Qquoteadv_Model_Core_Email_Template extends Mage_Core_Model_Email_Template
{
  	
  	/**
  	*
  	*	Force a clone of the mail object when cloning
  	*
  	*/
  	
  	function __clone(){
		if(is_object($this->_mail)) $this->_mail = clone $this->_mail;
  	}

}
