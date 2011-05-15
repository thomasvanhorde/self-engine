<?php

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

class BddMysqlCM {

    const Table_object = 'contentmanager';
    const Table_data = 'contentmanager_data';

    private $_collection;
    var $_requestArray;

    public function __construct(){}

    public function insert($dataArray){
        if($this->_collection == 'ContentManager'){
            $ObjectId = uniqid(true, true);
            $this->request("INSERT INTO `".self::Table_object."` (`_id`, `collection`) VALUES ('".$ObjectId."', '".$dataArray['collection']."')");
            unset($dataArray['collection']);
            return $this->insertCM($ObjectId, $dataArray);
        }
    }

    public function update($ObjectId, $dataArray){
        unset($dataArray['collection']);
        $this->removeData($ObjectId);
        if($this->insertCM($ObjectId, $dataArray))
            return true;
    }

    public function remove($ObjectId){
        $this->request("DELETE FROM ".self::Table_data." WHERE contentmanager_id='".$ObjectId."'");
        return $this->removeObject($ObjectId);
    }

    private function removeData($ObjectId){
        return $this->request("DELETE FROM ".self::Table_data." WHERE contentmanager_id='".$ObjectId."'");
    }

    private function removeObject($ObjectId){
        return $this->request("DELETE FROM ".self::Table_object." WHERE _id='".$ObjectId."'");
    }

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

    public function selectCollection($collection){
        $this->_collection = $collection;
        return $this;
    }

    public function find($param = false){
        if(!$param)
        $data = $this->request('SELECT * FROM '.self::Table_object.' as CM, '.self::Table_data.' as CMD
                                WHERE CM._id = CMD.contentmanager_id');
        else {
            if(isset($param['collection'])){
                $data = $this->request('SELECT * FROM '.self::Table_object.' as CM, '.self::Table_data.' as CMD
                                        WHERE CM._id = CMD.contentmanager_id AND CM.collection = "'.$param['collection'].'"');
            }
        }
        return (object)$data;
    }

    public function findOne($id){
        $data = $this->request('SELECT * FROM '.self::Table_object.' as CM, '.self::Table_data.' as CMD
                                WHERE CM._id = CMD.contentmanager_id
                                AND CM._id = "'.$id.'"
                                ');
        return $data[$id];
    }

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
    
}