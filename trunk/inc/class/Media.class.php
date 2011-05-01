<?php
/**
 * User: Thomas
 * Date: 12/04/11
 * Time: 22:16
 */


class Media {

    const IDprefix = 'node_';
    const stateClose = "closed";
    const stateOpen = "open";

    private $_data, $dataStruct;
    
    public function __construct(){
        $this->_data = file_get_contents(INFOS_JSON_MEDIA);
    }

    public function load(){
        return $this->_data;
    }

    private function assignIdParent($obj){
        $data = array();
        foreach($obj as $tmp){
           if(isset($tmp->attr->parent))
               $data[$tmp->attr->parent][] = $tmp;
        }
        return (object)$data;
    }

    private function assignId($obj){
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

        if($data->$id->attr->rel == 'videoYoutube'){
            $video = BASE::Load(CLASS_YOUTUBE)->getVideoEntry($data->$id->file->dataYoutube->id, true);
            $video->setVideoTitle($title);
            BASE::Load(CLASS_YOUTUBE)->updateEntry($video);
        }

        $data->$id->data = $title;
        $this->save(json_encode(array('media' => $data)));
        return json_encode(array('status'=> 1));
    }

    public function removeNode($nodeID){
        $data = $this->assignId(json_decode($this->load(), false)->media);
        $id = self::IDprefix.$nodeID;

        if($data->$id->state != self::stateClose){
            if($data->$id->attr->rel == 'videoYoutube'){
                $video = BASE::Load(CLASS_YOUTUBE)->getVideoEntry($data->$id->file->dataYoutube->id, true);
                BASE::Load(CLASS_YOUTUBE)->delete($video);
            }
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

}