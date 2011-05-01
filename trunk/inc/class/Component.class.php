<?php

/**
 *  @author Thomas VAN HORDE
 *  @description Abstract class for controller
 */


class Component {
    
	public $_view;

    public function __construct(){ }

    public function setConstruct(){
        $this->_view = Base::Load(CLASS_BASE)->getView();
    }

    public function setContentType($contentType){
        Base::Load(CLASS_BASE)->setContentType($contentType);
    }

}


