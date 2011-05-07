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

    public function get($id, $byParent = true){
        if($byParent)
            $data = $this->assignIdParent(json_decode($this->load(), false)->media);
        else
            $data = $this->assignId(json_decode($this->load(), false)->media);

        if(isset($data->$id))
            return json_encode($data->$id);

        return false;
    }

    public function addNode($parentID, $title, $type, $file = false){
        $data = json_decode($this->load(), true);
        $data = $data['media'];

        $id = time();
        $new['attr']['id'] = self::IDprefix.$id;
        $new['attr']['parent'] = self::IDprefix.$parentID;
        $new['attr']['rel'] = $type;
        $new['data'] = $title;
        $new['state'] = self::stateOpen;
        if($file)
            $new['file'] = $file;

        $data[] = $new;

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

            foreach($this->getExtensions() as $extension)
                if(isset($data->$id))
                    $extension->removeNode($data->$id);

            unset($data->$id);
            $this->save(json_encode(array('media' => $data)));
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
