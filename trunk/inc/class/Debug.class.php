<?php

/**
 *  @author Thomas VAN HORDE
 *  @description Use PqP Debug
 */


include ENGINE_URL.'inc/class/ext/pqp/index.php';

class Debug {

    /**
     * @param  $data
     * @return void
     */
	public function log($data){
		Console::log($data);
	}

    /**
     * @param  $exception
     * @return void
     */
	public function logError($exception){
		Console::logError($exception);
	}

    /**
     * @param  $var
     * @param  $name
     * @return void
     */
	public function logMemory($var = null, $name = null){
		Console::logMemory($var, $name);
	}

    /**
     * @return void
     */
	public function logSpeed(){
		Console::logSpeed();
	}

    /**
     * @param  $sql
     * @param  $start
     * @return void
     */
	public function logQuery($sql, $start){
		Console::logQuery($sql, $start);
	}


}


