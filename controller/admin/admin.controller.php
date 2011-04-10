<?php

class admin_controller {

    public $_contentManager;

    public  function admin_controller(){
        $this->_view = Base::Load(CLASS_COMPONENT)->_view;
        $this->_contentManager = Base::Load(CLASS_CONTENT_MANAGER);
        $this->_BBD = Base::Load(CLASS_BDD)->_connexion;
        
        // Left Nav
        $this->_view->addBlock('mainNav', 'admin_mainNav.tpl', 'view/admin/');
    }
	
    public  function defaut(){}

    public function phpinfo(){
        phpinfo();
        exit();
    }

}


