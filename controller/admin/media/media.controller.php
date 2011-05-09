<?php

class media_controller extends Component{

    private $_classMedia;

    function __construct(){
        $this->_classMedia = Base::Load(CLASS_MEDIA);
    }

    function defaut(){
        $this->_view->addBlock('content','defaut.tpl');
    }

    function getYoutubeForm(){
        $redirect = 'http://'.HTTP_HOST.'/admin/media/upload-youtube/'.$_GET['nodeID'].'/';
        exit(BASE::Load(CLASS_YOUTUBE)->uploadForm($redirect));
    }

    function data(){
        if(isset($_GET['id']))
            exit($this->_classMedia->get('node_'.$_GET['id']));
    }

    function createNode(){
        exit($this->_classMedia->addNode($_POST['id'], $_POST['title'], $_POST['type']));
    }

    function renameNode(){
        exit($this->_classMedia->renameNode($_POST['id'], $_POST['title']));
    }

    function removeNode(){
        exit($this->_classMedia->removeNode($_POST['id']));
    }

    function upload(){
        $upload = $this->_classMedia->upload($_FILES['new_media']);
        if (empty($upload->error)) {
            $this->_classMedia->addNode(
                $_POST['node'],
                $upload->file_src_name,
                $upload->file_src_mime,
                array('url' => stripslashes($upload->file_dst_pathname))
            );
            header('location: ../');exit();
        } else {
            echo 'error : ' . $upload->error;
        }
    }

    function uploadYoutbe(){
        $video = BASE::Load(CLASS_YOUTUBE)->getVideoEntry($_GET['id']);
        $video->setVideoPrivate();
        $data['id'] = $_GET['id'];
        $data['pictures'] = $video->getVideoThumbnails();
        $data['embed'] = 'http://www.youtube.com/embed/'.$_GET['id'];
        $data['flashPlayer'] = $video->getFlashPlayerUrl();
        $data['duration'] = $video->getVideoDuration();
    //    $data['description'] = $video->getVideoDescription();
        
        $this->_classMedia->addNode(
            $_GET['param'][0],
            $video->getVideoTitle(),
            'videoYoutube',
            array('dataYoutube' => $data)
        );

        header('location: ../../');exit();
    }

    function getPreview(){
        $mediaID = $_GET['param'][0];
        $data = json_decode($this->_classMedia->get('node_'.$mediaID,false));

        $this->_view->assign('media',$data);

        switch($data->attr->rel){
            case 'videoYoutube':
                $this->_view->addBlock('data','edit_youtube.tpl');
                break;
            default:
                $this->_view->addBlock('data','edit_default.tpl');
                break;
        }

        //var_dump($data);exit();
    }

    function POST_edit($data){
        foreach($data['data'] as $key => $value)
            $this->_classMedia->editData($data['nodeID'], $key, $value);
    }
}