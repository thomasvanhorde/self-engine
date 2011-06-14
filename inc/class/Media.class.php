<?php
/**
 * User: Thomas
 * Date: 12/04/11
 * Time: 22:16
 */


class Media extends Model{

    const IDprefix = 'node_';
    const stateClose = "closed";
    const stateOpen = "open";

    private $_data, $dataStruct;

    public function __construct(){
        $this->_data = file_get_contents(INFOS_JSON_MEDIA);
        $this->_numberUp = 0;
    }

    public function load($returnArray = false){
        if($returnArray)
            return json_decode($this->_data);
        else
            return $this->_data;
    }

    public function assignIdParent($obj){
        $data = array();
        foreach($obj as $tmp){
           if(isset($tmp->attr->parent))
               $data[$tmp->attr->parent][] = $tmp;
        }
        return (object)$data;
    }

    public function assignId($obj){
        $data = array();
        foreach($obj as $tmp){
           if(isset($tmp->attr->id))
               $data[$tmp->attr->id] = $tmp;
        }
        return (object)$data;
    }

    public function get($id, $byParent = true, $json = true){
        if($byParent)
            $data = $this->assignIdParent(json_decode($this->load(), false)->media);
        else
            $data = $this->assignId(json_decode($this->load(), false)->media);

        if(isset($data->$id))
            if($json)
                return json_encode($data->$id);
            else
                return $data->$id;
        
        return false;
    }

    public function addNode($parentID, $title, $type, $file = false, $saltID = ''){
        $data = json_decode($this->load(), true);
        $data = $data['media'];

        $id = time().$saltID;
        $new['attr']['id'] = self::IDprefix.$id;
        $new['attr']['parent'] = self::IDprefix.$parentID;
        $new['attr']['rel'] = $type;
        $new['data'] = $title;
        $new['state'] = self::stateOpen;
        if($file)
            $new['file'] = $file;

        $data[$new['attr']['id']] = $new;
        
        $this->save(json_encode(array('media' => $data)));

        return json_encode(array('status'=> 1, 'id' => $id));
    }

    public function addNodeArray($fileList){
        $data = json_decode($this->load(), true);
        $data = $data['media'];

        foreach($fileList as $file){
            $id = time().$file['saltID'];
            $new['attr']['id'] = self::IDprefix.$id;
            $new['attr']['parent'] = self::IDprefix.$file['parentID'];
            $new['attr']['rel'] = $file['type'];
            $new['data'] = $file['title'];
            $new['state'] = self::stateOpen;
            $new['file']['url'] = $file['file'];

            $data[$new['attr']['id']] = $new;
        }

        $this->save(json_encode(array('media' => $data)));

        return json_encode(array('status'=> 1, 'id' => $id));
    }

    public function renameNode($nodeID, $title){
        $data = $this->assignId(json_decode($this->load(), false)->media);
        $id = self::IDprefix.$nodeID;
        
        foreach($this->getExtensions() as $extension)
            $extension->renameNode($data->$id, $title);

        $data->$id->data = $title;
        $this->save(json_encode(array('media' => $data)));
        return json_encode(array('status'=> 1));
    }

    public function removeNode($nodeID){
        $data = $this->assignId(json_decode($this->load(), false)->media);
        $id = self::IDprefix.$nodeID;

        if($data->$id->state != self::stateClose){
            $nodeID = $data->$id;

            unset($data->$id);


            $this->save(json_encode(array('media' => $data)));

            foreach($this->getExtensions() as $extension)
                if(isset($nodeID))
                    $extension->removeNode($nodeID);

            return json_encode(array('status'=> 1));
        }
    }

    function upload($file){
        $upload = Base::Load(CLASS_UPLOAD);
        $upload->send($file, 'fr_FR');
        $upload->file_new_name_body = time();

        if($upload->file_is_image)
            $upload->Process('media/images/');
        elseif($upload->file_src_mime == 'application/pdf')
            $upload->Process('media/pdf/');
        elseif($upload->file_src_name_ext == 'zip')
            $upload->Process('media/zip/');
        else
            $upload->Process('media/');


        return $upload;
    }
    
    private function save($data){
        $fp = fopen (INFOS_JSON_MEDIA, "w+");
        fseek ($fp, 0);
        fputs ($fp, $data);
        fclose ($fp);
    }

    public function editData($nodeID, $key, $value){
        $data = $this->assignId(json_decode($this->load(), false)->media);
        $id = $nodeID;

        foreach($this->getExtensions() as $extension)
            $extension->editData($data->$id, $key, $value);

        $data->$id->$key = $value;
        $this->save(json_encode(array('media' => $data)));
        return json_encode(array('status'=> 1));
    }

}
