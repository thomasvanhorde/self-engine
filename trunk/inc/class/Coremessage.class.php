<?php

/**
 * Manages important messages (coremessage.xml).
 *
 * @author  Thomas Van Horde
 * @author  Fabien Nouaillat
 * @package self-engine
 */
class Coremessage
{
    private $_data;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Loads data from the engine.
        foreach (simplexml_load_file(ENGINE_URL.'inc/'.INFOS_XML_CORE_MESSAGE, null, true)->children() as $k => $e) {
            $this->_data[(string)$e['id']] = utf8_decode($e);
        }

        // Load data from the project.
        foreach(simplexml_load_file('inc/'.INFOS_XML_CORE_MESSAGE, null, true)->children() as $k => $e) {
            $this->_data[(string)$e['id']] = utf8_decode($e);
        }
    }

    /**
     * Sends a critic error.
     *
     * @param  $key
     */
    public function Critic($key)
    {
        exit((string)$this->_data[$key]);
    }

    /**
     * Sends a warning.
     *
     * @param  $key
     *
     * @return string
     */
    public function Warning($key)
    {
        return (string)$this->_data[$key];
    }

    /**
     * Sends a generic message.
     *
     * @param  $key
     *
     * @return string
     */
    public function Generic($key)
    {
        return (string)$this->_data[$key];
    }
}