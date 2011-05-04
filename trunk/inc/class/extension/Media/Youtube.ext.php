<?php

class Media_Youtube_extension {

    var $_yt;

    public function __construct(){}

    public function renameNode($data, $title){
        if(isset($data->file->dataYoutube->id)){
            $video = BASE::Load(CLASS_YOUTUBE)->getVideoEntry($data->file->dataYoutube->id, true);
            $video->setVideoTitle($title);
            $this->_yt->updateEntry($video);
        }
    }

    public function editData($data, $key, $value){
        if(isset($data->file->dataYoutube->id)){
            $video = BASE::Load(CLASS_YOUTUBE)->getVideoEntry($data->file->dataYoutube->id, true);

            switch($key){
                case 'description':
                    $video->setVideoDescription($value);
                    break;
                case 'title':
                    $video->setVideoTitle($value);
                    break;
            }

            BASE::Load(CLASS_YOUTUBE)->updateEntry($video);
        }
    }

    public function removeNode($data){
        if(isset($data->file->dataYoutube->id)){
            $video = BASE::Load(CLASS_YOUTUBE)->getVideoEntry($data->file->dataYoutube->id, true);
            BASE::Load(CLASS_YOUTUBE)->delete($video);
        }
    }
}