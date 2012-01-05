<?php

require_once ENGINE_URL.'inc/class/ext/pqp/index.php';

/**
 * Uses PqP Debug.
 *
 * @author Thomas VAN HORDE
 */
class Debug
{
    /**
     * @param  $data
     */
    public function log($data){
        Console::log($data);
    }

    /**
     * @param  $exception
     */
    public function logError($exception){
        Console::logError($exception);
    }

    /**
     * @param  $var
     * @param  $name
     */
    public function logMemory($var = null, $name = null){
        Console::logMemory($var, $name);
    }

    public function logSpeed(){
        Console::logSpeed();
    }

    /**
     * @param  $sql
     * @param  $start
     */
    public function logQuery($sql, $start){
        Console::logQuery($sql, $start);
    }
}

/* -----------------------------------------------------------------------------
  ~ Aenyhm's thoughts ~

  I wonder: why not simply use PqP? You do not modify the class, you just
  rewrite it without any change.
----------------------------------------------------------------------------- */