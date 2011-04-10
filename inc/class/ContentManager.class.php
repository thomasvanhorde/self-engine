<?php

define('CONTENT_MANAGER_COLLECTION','ContentManager');
define('COMPILED_DATA', 'compiled_data');
define('ATTRIBUTE_ID','_id');

include ENGINE_URL.FOLDER_CLASS.'ContentManager/ContentType.class.php';
include ENGINE_URL.FOLDER_CLASS.'ContentManager/ContentStruct.class.php';

class ContentManager {

    var $_type;
    var $_struct;

    function __construct(){
       $this->_type = new ContentType();
       $this->_struct = new ContentStruct();
       $this->_BBD = Base::Load(CLASS_BDD)->_connexion;
       $this->_collection = $this->_BBD->selectCollection(CONTENT_MANAGER_COLLECTION);
    }

    /***
     * @return 
     */
    public function getType(){
        return $this->_type->get();
    }

    /***
     * @param bool $structID
     * @return 
     */
    public function getStruct($structID = false){
        $structures =  $this->_struct->get();
        if($structID)
            $structures = $structures[$structID];
        return $structures;
    }

    /***
     * @param bool $structID
     * @return 
     */
    public function getStructAll($structID = false){
        $structures =  $this->_struct->getAll();
        if($structID)
            $structures = $structures[(string)$structID];
        return $structures;
    }

    /***
     * @param  $id
     * @return string
     */
    public function getCollectioName($id){
        return 'ContentManager_'.$id;
    }

    /***
     * @param bool $collection
     * @return array
     */
    public function getDataAll($collection = false){
        $ContentManager = $this->_BBD->selectCollection(CONTENT_MANAGER_COLLECTION);

        if($collection)
            $dataCM = $ContentManager->find(array('collection' => (string)$collection));
        else
            $dataCM = $ContentManager->find();

        $data = array();
        foreach($dataCM as $a){
            $data[(string)$a[ATTRIBUTE_ID]] = $a;
        }

        return $data;
    }

    public function save($data, $id = false){
        // Pas de sauvegarde d'objet compil� avec findOneWithChild()
        if(isset($data[COMPILED_DATA]) && $data[COMPILED_DATA]){
            Base::Load(CLASS_CORE_MESSAGE)->Critic('MESS_ERR_SAVE_COMPILED_OBJ');
        }else {
            if(!$id){ // new
                $save = $this->insert($data);
                if($save)
                    return $save;
            }
            else {// update
                if($this->update($data, $id))
                    return true;
            }
            return false;
        }
    }

    /***
     * @param  $data
     * @return bool
     */
    private function insert($data){
        $data['date_create'] = time();
        if($this->_collection->insert($data)){
            $data['id'] = (string)$data['_id'];
            return $data;
        }
        else
            return false;
    }


    /***
     * @param  $data
     * @param  $id
     * @return bool
     */
    private function update($data, $id){
        $data['date_update'] = time();
        $data['date_create'] = (int)$data['date_create'];
        $theObjId = new MongoId($id);
        unset($data['id']);
        // $this->_collection->update(array("_id"=>$theObjId), array('$set' => $data));
        if($this->_collection->update(array(ATTRIBUTE_ID=>$theObjId), $data))
            return true;
        else
            return false;
    }

    public function remove($id){
        $theObjId = new MongoId($id);
        if($this->_collection->remove(array(ATTRIBUTE_ID=>$theObjId), true))
            return true;
        else
            return false;
    }

    /***
     * @param  $id
     * @return 
     */
    public function findOne($id){
        $ContentManager = $this->_BBD->selectCollection(CONTENT_MANAGER_COLLECTION);
        $theObjId = new MongoId($id);
        $search = $ContentManager->findOne(array(ATTRIBUTE_ID=>$theObjId));

        if(is_array($search)){
            foreach($search as $i => $d)
                $content[$i] = $d;
        }
        else
            $content = null;

        return $content;
    }

    /***
     * @param  $id
     * @return null
     */
    function findOneWithChild($id){
        $data = (object)$this->findOne($id);
        foreach($data as $ref => $value){
            if(strlen($value) == strlen('4d76229711e18d9005000031') && $ref != ATTRIBUTE_ID){
                $tryRef = $this->findOne($value);
                if($tryRef != null)
                    $data->$ref = (object)$tryRef;
            }
        }
        $lock = COMPILED_DATA;
        $data->$lock = true;
        return $data;
    }

    /***
     * @return 
     */
    public function find($param = false){
        $ContentManager = $this->_BBD->selectCollection(CONTENT_MANAGER_COLLECTION);

        if($param){
            $tmp = $ContentManager->find($param);
            foreach($tmp as $i=> $u){
                $dataCM[$i] = $u;
            }
            if(isset($dataCM) && is_array($dataCM))
                $dataCM = (object)$dataCM;
            else
                return false;
        }
        else
            $dataCM = $ContentManager->find();
        return $dataCM;
    }

}


