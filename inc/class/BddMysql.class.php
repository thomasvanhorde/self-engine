<?php
/**
* Engine Class Bdd Mysql
* Init db connexion
*
* @author: Thomas VAN HORDE <thomas.vanhorde@gmail.com>
* @version: 1
*/


class BddMysql {

    var $_connexion;

    public function __construct(){
        $db = mysql_connect(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PWD);
        mysql_select_db(MYSQL_BASE,$db);
        $this->_connexion = new BddMysqlCM();
    }


    public function __destruct(){
    //    mysql_close();        Incompatible et inutile avec le singleton
    }

    
}

/**
* Engine Class Bdd Mysql
* Init db Content Manager connexion
*
* @author: Thomas VAN HORDE <thomas.vanhorde@gmail.com>
* @version: 1
*/

class BddMysqlCM {

    const Table_object = 'contentmanager';
    const Table_data = 'contentmanager_data';

    private $_collection;
    private $_sort;
    private $_limit;

    var $_requestArray;

    public function __construct(){}

    /**
     * Enregistre les données d'un formulaire
     * @param  $dataArray array donnée à enregistrer
     * @return bool
     */
    public function insert($dataArray){
        if($this->_collection == 'ContentManager'){
            $ObjectId = uniqid(true, true);
            $this->request("INSERT INTO `".self::Table_object."` (`_id`, `collection`) VALUES ('".$ObjectId."', '".$dataArray['collection']."')");
            unset($dataArray['collection']);
            return $this->insertCM($ObjectId, $dataArray);
        }
    }

    /**
     * Met à jours les données
     * @param  $ObjectId
     * @param  $dataArray
     * @return bool
     */
    public function update($ObjectId, $dataArray){
        unset($dataArray['collection']);
        $this->removeData($ObjectId);
        if($this->insertCM($ObjectId, $dataArray))
            return true;
    }

    /**
     * Supprime les données
     * @param  $ObjectId
     * @return array|resource
     */
    public function remove($ObjectId){
        $this->request("DELETE FROM ".self::Table_data." WHERE contentmanager_id='".$ObjectId."'");
        return $this->removeObject($ObjectId);
    }

    /**
     * Supprime les données d'un enregistrement
     * @param  $ObjectId
     * @return array|resource
     */
    private function removeData($ObjectId){
        return $this->request("DELETE FROM ".self::Table_data." WHERE contentmanager_id='".$ObjectId."'");
    }

    /**
     * Supprime l'objet
     * @param  $ObjectId
     * @return array|resource
     */
    private function removeObject($ObjectId){
        return $this->request("DELETE FROM ".self::Table_object." WHERE _id='".$ObjectId."'");
    }

    /**
     * Sauvegarde les données d'un objet
     * @param  $ObjectId
     * @param  $dataArray
     * @return bool
     */
    private function insertCM($ObjectId, $dataArray){
        if(is_array($dataArray)){
            foreach($dataArray as $key => $data){
                if(!empty($data)){
                    if(!is_array($data)){
                        $this->request("INSERT INTO  `".self::Table_data."` (
                                        `_id` ,
                                        `parent_id` ,
                                        `contentmanager_id` ,
                                        `field` ,
                                        `value`
                                        )
                                        VALUES (
                                        NULL ,  '0',  '".$ObjectId."',  '".$key."',  '".addslashes($data)."'
                                        );");
                    }
                    else{
                        $this->insertCM($ObjectId, $data);
                    }
                }
            }
            return true;
        }
    }

    /**
     * Selectionne une structure
     * @param  $collection
     * @return BddMysqlCM
     */
    public function selectCollection($collection){
        $this->_collection = $collection;
        return $this;
    }

    /**
     * Retrouve une liste d'objet
     * @param bool $param
     * @return object
     */
    public function find($param = false){
        if(!$param)
        $data = $this->request('SELECT * FROM '.self::Table_object.' as CM, '.self::Table_data.' as CMD
                                WHERE CM._id = CMD.contentmanager_id');
        else {
            $request = 'SELECT * FROM '.self::Table_object.' as CM, '.self::Table_data.' as CMD
                        WHERE CM._id = CMD.contentmanager_id';

            /* Listes des parametres */
            if(isset($param['collection']))
                $request .= ' AND CM.collection = "'.$param['collection'].'"';

            if(isset($param['sort']))
                $request .= $param['sort'];

            if(isset($param['limit']))
                $request .= $param['limit'];

         //   exit($request);
            
            $data = $this->request($request);
        }
        return (object)$data;
    }

    /**
     * Retrouve un objet
     * @param  $id
     * @return
     */
    public function findOne($id){
        $data = $this->request('SELECT * FROM '.self::Table_object.' as CM, '.self::Table_data.' as CMD
                                WHERE CM._id = CMD.contentmanager_id
                                AND CM._id = "'.$id.'"
                                ');
        return $data[$id];
    }

    /**
     * Effectue les requêtes SQL
     * Private ?
     * @param  $request
     * @return array|resource
     */
    public function request($request){
        $this->requestArray[] = $request;
        $myData = array();

        $req = mysql_query($request) or die('Erreur SQL !<br>'.$request.'<br>'.mysql_error());
        
        if(is_bool($req))
            return $req;
        
        while($data = mysql_fetch_assoc($req)){
            foreach($data as $d){
                $myData[$data['contentmanager_id']]['_id'] = $data['contentmanager_id'];
                $myData[$data['contentmanager_id']]['collection'] = $data['collection'];
                $myData[$data['contentmanager_id']][$data['field']] = $data['value'];
            }
        }
        return (array)$myData;
    }

    public function execute(){
        $param = array();
        if(!empty($this->_sort)){
            $param['sort'] = ' ORDER BY '.$this->_sort[0];
            if($this->_sort[1] == 1)
                $param['sort'] .= ' ASC';
            else
                $param['sort'] .= ' DESC';
        }
        if(!empty($this->_limit)){
            $param['limit'] = ' LIMIT '.$this->_limit;
        }


        return $this->find($param);
    }

    public function setSort($filter){
        $this->_sort = $filter;
    }
    
    public function setLimit($limit){
        $this->_limit = $limit;
    }

}