<?php

class ContentType {
    private $_data;

    public  function __construct(){
        $this->load();
    }

    public  function load(){
        foreach($this->loadXml()->children() as $k => $e)
            $this->_data[(string)$e['id']] = $e;
    }

    public  function loadXml(){
        return simplexml_load_file(ENGINE_URL.FOLDER_INC.FOLDER_CONTENT_MANAGER.INFOS_XML_CONTENT_TYPE, NULL, true);
    }

    public  function get(){
        return $this->_data;
    }
}


