<?php

class content_controller {

    public  function __construct(){
        $this->_view = Base::Load('Component')->_view;
        $this->_contentManager = Base::Load(CLASS_CONTENT_MANAGER);
        $this->_BBD = Base::Load(CLASS_BDD)->_connexion;
        // Left Nav
        $this->_view->addBlock('mainNav', 'admin_mainNav.tpl', 'view/admin/');
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
        $this->_view->assign('data',$content);
        $this->_view->assign('id',$id);
        $this->add($content['collection']);
    }


    public function add($type){
        $struct = $this->_contentManager->getStruct($type);
        $type = $this->_contentManager->getType();

        $data = (array)$struct;
        $data['id'] = $data['@attributes']['id'];
        $data['types'] = (array)$data['types'];

        foreach($data['types']['type'] as $i => $u){
            $data['types'][$i] = (array)$data['types']['type'][$i];
            $data['types'][$i]['refType'] = $data['types'][$i]['@attributes']['refType'];

            if(isset($data['types'][$i]['valeur']))
            $data['types'][$i]['valeur'] = (string)$data['types'][$i]['valeur'];
        }
        unset($data['types']['type']);


        // $this->_contentManager->getStructAll($rowData['collection']);
        foreach($data['types'] as $t){
            if(!empty($t['contentRef'])){
                $ref = $t['contentRef'];
                $ContentData = $this->_contentManager->getDataAll($ref);
                foreach($ContentData  as $uidData => $u){
                    $StrucData = $this->_contentManager->getStructAll($u['collection']);
                    foreach($StrucData->types->type as $t){
                        if($t->index){
                            $index[$ref][$uidData] = $u[(string)$t->id];
                            break;
                        }
                    }
                }
            }
        }
        if(isset($index))
            $this->_view->assign('index',$index);
    
        $this->_view->assign('typeList',$type);
        $this->_view->assign('struct',$data);
        $this->_view->addBlock('content', 'admin_ContentManager_contentEdit.tpl');
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
