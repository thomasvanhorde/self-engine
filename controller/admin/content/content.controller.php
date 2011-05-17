<?php

/**
* Controlleur content manager/content
* Edition du contenu du content Manager
*
* @author: Thomas VAN HORDE <thomas.vanhorde@gmail.com>
* @version: 1
*/

class content_controller extends Component{


    /**
     * Init class need
     */
    public  function __construct(){
        $this->_contentManager = Base::Load(CLASS_CONTENT_MANAGER);
        $this->_simpleCM = Base::Load(CLASS_SIMPLE_CM);
        $this->_media = Base::Load(CLASS_MEDIA);
    }

    /**
     * Routage des demandes
     * @return void
     */
    public  function defaut(){
        if(isset($_GET['param'][0])){
            if($_GET['param'][0] == 'ajouter')  // Ajouter
                $this->add($_GET['param'][1]);
            elseif($_GET['param'][0] == 'delete')  // Supprimer
                $this->remove($_GET['param'][1]);
            else
                $this->edit($_GET['param'][0]);   // Editer
        }
        else {      // List
            $this->listAll();
        }

    }

    /**
     * Listing de l'ensemble des contenus
     * @return void
     */
    public  function listAll(){
        $data = array();
        $struct = $this->_contentManager->getStructAll();
        $dataCM = $this->_contentManager->find();

        foreach($struct as $idS => $strData){
            $data[$idS]['locked'] = (string)$strData[@locked];
            $data[$idS]['name'] = (string)$strData->name;
            $data[$idS]['description'] = (string)$strData->description;

            foreach($dataCM as $d){
                if(isset($d['collection']) && $d['collection'] == $idS){
                    $data[$idS]['data'][(string)$d['_id']] = $d;
                    unset($data[$idS]['data'][(string)$d['_id']]['_id']);
                }
            }
            foreach($struct[$idS]->types->type as $chmp){
                if(isset($chmp->index)){
                    $data[$idS]['index'][] = (string)$chmp->id;
                }
            }
        }

        $this->_view->assign('typeList',$data);
        $this->_view->addBlock('content', 'admin_ContentManager_contentList.tpl');
    }

    /**
     * Efface un contenu en fonction de son ID
     * @param  $id string   Id du contenu
     * @return void
     */
    public  function remove($id){
        if($this->_contentManager->remove($id))
            header('location: ../../');
        exit();
    }

    /**
     * Edite un contenu en fonction de son ID
     * @param  $id string   Id du contenu
     * @return void
     */
    public function edit($id){
        $content = $this->_contentManager->findOne($id);
        $this->_simpleCM->setCollection($content['collection']);
        $this->_simpleCM->editForm('content', $id, 'contentEdit');
    }

    /**
     * Ajoute un contenu en fonction de son ID type
     * @param  $type string   Id du type
     * @return void
     */
    public function add($type){
        $this->_simpleCM->setCollection($type);
        $this->_simpleCM->addForm('content', 'contentEdit');
    }

    /**
     * Liste les medias enregistré dans la médiathèque
     * Utilisé lors de l'édition d'un média au sein d'un select
     * @return void
     */
    public function getMedia(){
        $mediaData = $this->_media->load(true);
        $this->_view->assign('mediaData',$mediaData);
        $this->_view->addBlock('data', 'admin_ContentManager_contentMedia.tpl');
    }

    /**
     * Liste les medias enregistré dans la médiathèque
     * Utilisé lors de l'édition d'un média dans le RTE
     * @return void
     */
    public function getMediaRTE(){
        $mediaData = $this->_media->load(true);
        $this->_view->assign('elementID',$_GET['param'][0]);
        $this->_view->assign('mediaData',$mediaData);
        $this->_view->addBlock('data', 'admin_ContentManager_contentMediaRTE.tpl');
    }

    /**
     * Sauvegarde le contenu d'un formulaire de Content Manager
     * @param  $data array  Contenu de formulaire
     * @return void
     */
    public function POST_contentEdit($data){
        if(empty($data['id'])){ // new
            if($this->_contentManager->save($data))
                header('location: '.$_SERVER['REDIRECT_URL'].'../../');
        }
        else {// update
            if($this->_contentManager->save($data, $data['id']))
                header('location: '.$_SERVER['REDIRECT_URL']);
        }
        exit();
    }
}
