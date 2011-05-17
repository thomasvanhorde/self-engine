<?php

/**
* Fichier d'accès admin & phpInfo()
*
* @author: Thomas VAN HORDE <thomas.vanhorde@gmail.com>
* @version: 1
*/

class admin_controller extends Component {

    public  function defaut(){}

    public function phpinfo(){
        phpinfo();
        exit();
    }

}


