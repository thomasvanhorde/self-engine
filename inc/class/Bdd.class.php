<?php

/**
 *  @author Thomas VAN HORDE
 *  @description Use Doctrine
 */


/*
 * RESSOURCE DOCTRINE
 *
 * DROP
 * http://www.doctrine-project.org/documentation/manual/1_0/hu/database-abstraction-layer:export:deleting-database-elements
 *
 */

if(file_exists(FOLDER_CLASS_EXT.'Doctrine-1.2.3/Doctrine/Core.php'))
	require_once FOLDER_CLASS_EXT.'Doctrine-1.2.3/Doctrine/Core.php';
elseif(file_exists(ENGINE_URL.FOLDER_CLASS_EXT.'Doctrine-1.2.3/Doctrine/Core.php'))
	require_once ENGINE_URL.FOLDER_CLASS_EXT.'Doctrine-1.2.3/Doctrine/Core.php';
else
    Base::Load(CLASS_CORE_MESSAGE)->Critic('ERR_LOAD_CLASS_DOCTRINE');
            
spl_autoload_register(array('Doctrine_Core', 'autoload'));

class Bdd extends Doctrine_Core{
	
	var $_connexion;
	var $_query;

    /**
     * @return void
     * @description init connexion
     */
	function Bdd(){
		$this->_connexion = Doctrine_Manager::connection(BDD_DOCTRINE);
		$this->_query = base::load('Doctrine_Query');
	}

		
    function getFrom($attr, $value, $row, $tableName) {
        $request = Base::Load(CLASS_BDD)->_query
                                        ->create()
                                        ->select($row)
                                        ->from($tableName)
                                        ->where($attr." = '".$value."'")
                                        ->execute(array(), Doctrine_Core::HYDRATE_SCALAR);
        return $request;
    }


    function getNumberAttr($attr, $value, $tableName) {
        if(!is_array($attr) && !is_array($value))
            $request  = $this->getNumberAttrSimple($attr, $value, $tableName);
        else
            $request  = $this->getNumberAttrArray($attr, $value, $tableName);

        return $request;
    }


    private function getNumberAttrSimple($attr, $value, $tableName) {
        $request = Base::Load(CLASS_BDD)->_query
                                        ->create()
                                        ->select($attr)
                                        ->from($tableName.' u')
                                        ->where($attr." = '".$value."'")
                                        ->count();
        return $request;
    }

    private function getNumberAttrArray($attr, $value, $tableName) {
        $where = '';
        foreach($attr as $i => $at){
            if(!empty($where))
                $where .= " AND ";
            $where .= $at." = '".$value[$i]."'";
        }
        $request = Base::Load(CLASS_BDD)->_query
                                        ->create()
                                        ->select($attr[0])
                                        ->from($tableName.' u')
                                        ->where($where)
                                        ->count();
        return $request;
    }



    /**
     * @param  $tableName
     * @return void
     * @description init table in bdd
     */
	function InitTable($tableName){
		include FOLDER_CLASS_BDD_MODEL.$tableName.CLASS_EXTENSION;
		$table = $this->getTable($tableName.'Model');	
		try {
		$this->_connexion->export->createTable(	$table->getTableName(), 
												$table->getColumns()
												);
		} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
			echo $e->getMessage(); // On l'affiche.
		}
	}

    /**
     * @param  $tableName
     * @return void
     */
    function DropTable($tableName){
        try {
            $this->_connexion->export->dropTable(strtolower($tableName));
            return true;
        }
        catch(Doctrine_Connection_Exception $e) { echo $e; return false;}
    }

    /**
     * @param  $ClassName
     * @param bool $singleton
     * @return
     * @description load table class & model
     */
	function Load($ClassName, $singleton = true){
		static $instance;
		if(isset($instance[$ClassName])
                && $singleton
                ||
                (class_exists($ClassName)
                        &&
                        isset($instance[$ClassName])
                        &&
                        $instance[$ClassName] != NULL
                )
        ) {
			return $instance[$ClassName];
		}
		else {
			if(defined($ClassName))	// A partir d'un nom de constante ?
				$ClassName = constant(ClassName);

			if(file_exists(FOLDER_CLASS_BDD_MODEL.$ClassName.CLASS_EXTENSION))
				include_once FOLDER_CLASS_BDD_MODEL.$ClassName.CLASS_EXTENSION;
			elseif(file_exists(ENGINE_URL.FOLDER_CLASS_BDD_MODEL.$ClassName.CLASS_EXTENSION))
				include_once ENGINE_URL.FOLDER_CLASS_BDD_MODEL.$ClassName.CLASS_EXTENSION;
				
			if(file_exists(FOLDER_CLASS_BDD_CLASS.$ClassName.CLASS_EXTENSION))
				include_once FOLDER_CLASS_BDD_CLASS.$ClassName.CLASS_EXTENSION;
			elseif(file_exists(ENGINE_URL.FOLDER_CLASS_BDD_CLASS.$ClassName.CLASS_EXTENSION))
				include_once ENGINE_URL.FOLDER_CLASS_BDD_CLASS.$ClassName.CLASS_EXTENSION;
			
            $ClassNameT = $ClassName.'Table';
            $ClassNameM = $ClassName.'Model';
            $objet = new $ClassNameM($ClassName, $this->_connexion);
            $objetT = new $ClassNameT($ClassName, $this->_connexion);

			$instance[$ClassName] = array('model' => &$objet,'class' => &$objetT);	// Référence aux objets pour le Singleton

            return $instance[$ClassName];
		}

	}

}

?>