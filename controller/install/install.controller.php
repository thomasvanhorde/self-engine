<?php

class install_controller{

    public $_instance;

    public  function __construct(){
        $this->_instance = Base::Load(CLASS_INSTALL);
    }

    public  function defaut(){
        echo 'Suppresion des tables : <br />';
        $this->_instance->dropTable();
        echo 'Installation des tables : <br />';
        $this->_instance->InitTable();
    }
}


