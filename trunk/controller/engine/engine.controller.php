<?php
/**
* Controlleur engine
* Gestion de page spécifiques
*
*
* @author: Thomas VAN HORDE <thomas.vanhorde@gmail.com>
* @version: 1
*/

class engine_controller extends Component{

    public function defaut(){}

    public function qrcode(){
        if(isset($_GET['param'][0])){
            Base::Load(CLASS_QR)->png($_GET['param'][0], false, 'L', 8);
            exit();
        }
    }

    /**
     * Générate /robot.txt
     * @return void
     */
    public function robot(){
        $this->setContentType('text/plain');
        $this->_view->addBlock('data', 'robot.tpl');
    }

    /**
     * Générate sitemap.xml
     * @return void
     */
    public function siteMap(){
        $this->setContentType('application/xml');
        $this->_view->addBlock('data', 'site_map.tpl');
    }

}


