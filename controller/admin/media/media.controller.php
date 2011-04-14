<?php

class media_controller {

    private $_data, $_classMedia;

    function __construct(){
        $this->_view = Base::Load('Component')->_view;
        $this->_contentManager = Base::Load(CLASS_CONTENT_MANAGER);
        $this->_view->addBlock('mainNav', 'admin_mainNav.tpl', 'view/admin/');

        $this->_classMedia = Base::Load(CLASS_MEDIA);
    }

    function defaut(){
        $youtube = Base::Load(CLASS_YOUTUBE);
        $youtube->uploadForm();
        $this->_view->addBlock('content','defaut.tpl');
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
            echo 'image renamed "foo" copied';
            var_dump($_POST);
            var_dump($upload);
            $this->_classMedia->addNode(
                $_POST['node'],
                $upload->file_src_name,
                $upload->file_src_mime,
                array('url' => $upload->file_dst_pathname)
            );
            header('location: ../');
        } else {
            echo 'error : ' . $upload->error;
        }
    }
}