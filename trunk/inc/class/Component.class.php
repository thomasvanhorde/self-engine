<?php

/**
 *  @author Thomas VAN HORDE
 *  @description Abstract class for controller
 */



class Component {
	var $_view;
	var $_bdd;
	public function __construct(){
		$this->_bdd = Base::Load(CLASS_BDD);
	}
}


