<?php

/**
 *  @author Thomas VAN HORDE
 *  @description Abstract class for controller
 */


class Component {
    
	public $_view;
	public $_bdd;

    public function __construct(){

    }

    public function setConstruct(){
        $this->_bdd = Base::Load(CLASS_BDD)->_connexion;
        $this->_view = Base::Load(CLASS_BASE)->getView();
    }

}


