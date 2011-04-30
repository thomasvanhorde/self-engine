<?php

class engine_controller extends Component{

    public function defaut(){}

    public function robot(){
        $this->setContentType('text/plain');
        $this->_view->addBlock('data', 'robot.tpl');
    }
    
    public function siteMap(){
        $this->setContentType('application/xml');
        $this->_view->addBlock('data', 'site_map.tpl');
    }

}


