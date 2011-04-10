<?php

class ContentStruct {

    private $_dataSite;
    private $_dataAll;
    
    public  function __construct(){
        $this->load();
    }

    public  function load(){
        foreach($this->loadXmlEngine()->children() as $k => $e){
            $this->_dataAll[(string)$e['id']] = $e;
        }
        foreach($this->loadXmlSite()->children() as $k => $e){
            $this->_dataSite[(string)$e['id']] = $e;
            $this->_dataAll[(string)$e['id']] = $e;
        }
    }

    public  function loadXmlEngine(){
        return simplexml_load_file(ENGINE_URL.FOLDER_INC.FOLDER_CONTENT_MANAGER.INFOS_XML_CONTENT_STRUCT, NULL, true);
    }

    public  function loadXmlSite(){
        return simplexml_load_file(FOLDER_INC.INFOS_XML_CONTENT_STRUCT, NULL, true);    
    }

    public  function get(){
        return $this->_dataSite;
    }

    public  function getAll(){
        return $this->_dataAll;
    }

    public  function delete($uid){
        $out = $Xml = $this->loadXmlSite();
        $i = 0;
        foreach($Xml as $k => $d){
           if($d[@id] == $uid && $d[@locked] == 'false')
               unset($out->element->$i);
           $i++;
        }
        $out->saveXML(FOLDER_INC.INFOS_XML_CONTENT_STRUCT);
    }

    public  function save($data){
        $Xml = $this->loadXmlSite();
        $xmlArray = $this->get();

        if(isset($data['id']) && !empty($data['id'])){ // If id = edit
            $i = 0;
            foreach($xmlArray as $k => $d){
                if((string)$d[@id] == $data['id']){
                    $uid = (string)$d[@id];
                    unset($Xml->element->$i);
                    break;
                }
                $i++;
            }
        }
        else {  // else = new
            $uid = 1;
            foreach($xmlArray as $k => $d){
                if((string)$d[@id] >= $uid)
                    $uid = (string)$d[@id] + 1;
            }
        }

        $newNode = $Xml->addChild('element');
        $newNode->addAttribute('id', $uid);
        $newNode->addAttribute('locked', 'false');
        $newNode->addChild('name', $data['name']);
        $newNode->addChild('description', $data['description']);
        if(count($data['data']) > 0) $newNodeTypes = $newNode->addChild('types');

        foreach($data['data'] as $i => $d){
            $newNodeTypesType[$i] = $newNodeTypes->addChild('type');
            foreach($d as $key => $value){
                if($key != 'type')
                    $newNodeTypesType[$i]->addChild($key, $value);
                else
                    $newNodeTypesType[$i]->addAttribute('refType', $value);
            }
        }

  
        $Xml->saveXML(FOLDER_INC.INFOS_XML_CONTENT_STRUCT);

        return $uid;
    }

}

