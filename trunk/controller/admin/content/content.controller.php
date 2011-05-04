<?php

class content_controller extends Component{

    public  function __construct(){
        $this->_contentManager = Base::Load(CLASS_CONTENT_MANAGER);
        $this->_simpleCM = Base::Load(CLASS_SIMPLE_CM);
    }

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

    public  function remove($id){
        if($this->_contentManager->remove($id))
            header('location: ../../');
        exit();
    }

    public  function edit($id){
        $content = $this->_contentManager->findOne($id);
        $this->_simpleCM->setCollection($content['collection']);
        $this->_simpleCM->editForm('content', $id, 'contentEdit');
    }


    public function add($type){
        $this->_simpleCM->setCollection($type);
        $this->_simpleCM->addForm('content', 'contentEdit');
    }


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
