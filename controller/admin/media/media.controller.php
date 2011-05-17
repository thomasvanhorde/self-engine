<?php
/**
* Acces à la médiathèque
*
* @author: Thomas VAN HORDE <thomas.vanhorde@gmail.com>
* @version: 1
*/


class media_controller extends Component{

    private $_classMedia;

    /**
     * Class need
     */
    function __construct(){
        $this->_classMedia = Base::Load(CLASS_MEDIA);
    }

    /**
     * Page par défaut
     * @return void
     */
    function defaut(){
        $this->_view->addBlock('content','defaut.tpl');
    }

    /**
     * Génère un formulaire d'upload pour Youtube
     * @return void
     */
    function getYoutubeForm(){
        $redirect = 'http://'.HTTP_HOST.'/admin/media/upload-youtube/'.$_GET['nodeID'].'/';
        exit(BASE::Load(CLASS_YOUTUBE)->uploadForm($redirect));
    }

    /**
     * Retourne l'ensemble des données médiathèque sous forme Json
     * @return void
     */
    function data(){
        if(isset($_GET['id']))
            exit($this->_classMedia->get('node_'.$_GET['id']));
    }

    /**
     * Ajoute un média
     * @return void
     */
    function createNode(){
        exit($this->_classMedia->addNode($_POST['id'], $_POST['title'], $_POST['type']));
    }

    /**
     * Renomme un média
     * @return void
     */
    function renameNode(){
        exit($this->_classMedia->renameNode($_POST['id'], $_POST['title']));
    }

    /**
     * Supprime un média
     * @return void
     */
    function removeNode(){
        exit($this->_classMedia->removeNode($_POST['id']));
    }

    /**
     * Upload un média
     * @return void
     */
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

    /**
     * Retour de la page Youtube, fichier deja uploader sur les serveurs YT
     * Enregisrtre uniquement le node dans la médiathèque
     * @return void
     */
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

    /**
     * Prévisualisé les médias
     * @return void
     */
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

    /**
     * Editer une donnée d'un node média
     * @param  $data array  Donnée modifié key=>value
     * @return void
     */
    function POST_edit($data){
        foreach($data['data'] as $key => $value)
            $this->_classMedia->editData($data['nodeID'], $key, $value);
    }
}