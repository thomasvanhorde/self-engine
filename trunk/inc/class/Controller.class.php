<?php

/**
 *  @author Thomas VAN HORDE
 *  @description Call Controller
 */



class Controller {

    /**
     * @param bool $ControllerName
     * @param bool $method
     * @return void
     */
	function Controller($ControllerName = false, $method = false){
		if($ControllerName) {
            $ControllerName = explode('/', $ControllerName);
            // Gestion des paramètres de la méthode (facultatif)
            $a = explode('#(#', $method);
            $method = $a[0];
            if(isset($a[1])){
                $b = explode('#)#', $a[1]);
                $array = unserialize($b[0]);
            }

            if(!class_exists($ControllerName[count($ControllerName)-1].CONTROLLER_NAME_EXT)) {
                if(file_exists(FOLDER_APPLICATION.implode('/',$ControllerName).'/'.$ControllerName[count($ControllerName)-1].CONTROLLER_EXT))
                    include_once FOLDER_APPLICATION.implode('/',$ControllerName).'/'.$ControllerName[count($ControllerName)-1].CONTROLLER_EXT;
                elseif(file_exists(ENGINE_URL.FOLDER_APPLICATION.implode('/',$ControllerName).'/'.$ControllerName[count($ControllerName)-1].CONTROLLER_EXT))
                    include_once ENGINE_URL.FOLDER_APPLICATION.implode('/',$ControllerName).'/'.$ControllerName[count($ControllerName)-1].CONTROLLER_EXT;
            }
            
            $ControllerName = $ControllerName[count($ControllerName)-1].CONTROLLER_NAME_EXT;

            // Call view instance
            $ControlerObj = new $ControllerName;
            if(method_exists($ControlerObj,'setConstruct'))
                $ControlerObj->setConstruct();
            else
                Base::Load(CLASS_CORE_MESSAGE)->Critic('ERR_EXTENDS_CONTROLLER');
            
			if(!$method)
				$method = INFOS_METHOD_DEFAUT;

			// On appel la méthode
            if(isset($array) && is_array($array))
			    $ControlerObj->$method($array);
            else
                $ControlerObj->$method();


		}
	}
	
}

