<?php

/**
 * Define CoreMessage
 */
class Coremessage {

    private $_data;
    
	function __construct(){
        // Load data from engine coremssage.xml
        foreach(simplexml_load_file(ENGINE_URL.'inc/'.INFOS_XML_CORE_MESSAGE, NULL, true)->children() as $k => $e)
            $this->_data[(string)$e['id']] = utf8_decode($e);

        // Load data from www coremssage.xml 
        foreach(simplexml_load_file('inc/'.INFOS_XML_CORE_MESSAGE, NULL, true)->children() as $k => $e)
            $this->_data[(string)$e['id']] = utf8_decode($e);
    }

    /**
     * @param  $key
     * @return exit()
     */
	public function Critic($key){
        exit((string)$this->_data[$key]);
	}

    /**
     * @param  $key
     * @return string
     */
	public function Warning($key){
        return (string)$this->_data[$key];
	}

    /**
     * @param  $key
     * @return string
     */
	public function Generic($key){
        return (string)$this->_data[$key];
	}

}

