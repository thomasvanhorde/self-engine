<?php

/**
 * Created by PhpStorm.
 * User: vanhorde
 * Date: 23 déc. 2010
 * Time: 17:01:51
 * To change this template use File | Settings | File Templates.
 */

class Install {

    private $_bdd;

    public function __construct(){
        $this->_bdd = Base::Load(CLASS_BDD);
    }

    /**
     * @return void
     * @description Init Table in Bdd
     */
    public function InitTable(){
        foreach($this->getTableName() as $table){
            echo $table.'<br />';
            $this->_bdd->InitTable($table);
        }
    }

    public function dropTable(){
        foreach($this->getTableName() as $table){
            if($this->_bdd->DropTable($table))
                echo $table.'<br />';
        }   
    }

    /**
     * @return array Bdd TableName
     */
    private function getTableName(){
        $name = array();
        $MyDirectory = opendir(FOLDER_CLASS_BDD_MODEL) or die(Base::Load(CLASS_CORE_MESSAGE)->Warning('MESS_FOLDER_BDD_NOT_FOUND').FOLDER_CLASS_BDD_MODEL);
          while($Entry = readdir($MyDirectory)) {
              if($Entry != '.svn' && $Entry !=  '.' && $Entry !=  '..' && preg_match('/.'.CLASS_EXTENSION.'/', $Entry, $matches)){
                $u = explode(CLASS_EXTENSION, $Entry);
                $name[] =  $u[0];
              }
          }
        closedir($MyDirectory);
        return $name;
    }

}
