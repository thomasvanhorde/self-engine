<?php

class Media_Youtube_extension {

    var $_yt;

    public function __construct(){
        $this->_yt = BASE::Load(CLASS_YOUTUBE);
    }

    public function renameNode($data, $title){
        $video = $this->_yt->getVideoEntry($data->file->dataYoutube->id, true);
        $video->setVideoTitle($title);
        $this->_yt->updateEntry($video);
    }

    public function removeNode($data){
        $video = BASE::Load(CLASS_YOUTUBE)->getVideoEntry($data->file->dataYoutube->id, true);
        BASE::Load(CLASS_YOUTUBE)->delete($video);
    }
}