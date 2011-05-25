<?php

/**
* Class component pour gérer les vue automatiquement dans les controlleur
* <<controlleur class>> extends Component
*
* @author: Thomas VAN HORDE <thomas.vanhorde@gmail.com>
* @version: 1
*/


class Component {
    
	public $_view;

    public function defaut(){
        exit(Base::Load(CLASS_CORE_MESSAGE)->Critic('ERR_DEFAULT_METHOD'));
    }

    public function __construct(){ }

    /**
     * Assigne la vue principal
     * @return void
     */
    public function setConstruct(){
        $this->_view = Base::Load(CLASS_BASE)->getView();
    }

    /**
     * Changé le type de contenu
     * defaut : html
     * @param  $contentType
     * @return void
     */
    public function setContentType($contentType){
        Base::Load(CLASS_BASE)->setContentType($contentType);
    }

}


