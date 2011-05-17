<?php
/**
* Engine Class Bdd MongoDB
* Init db connexion
*
* @author: Thomas VAN HORDE <thomas.vanhorde@gmail.com>
* @version: 1
*/

class BddMongoDB {

    var $_connexion;

    function __construct() {
        try {
            $connexion = new mongo(MONGO_HOST);
        } catch (Exception $e) {
            throw new Exception('Can\'t connect MongoDB server');
        }

        $this->_connexion = $connexion->selectDB(MONGO_BASE);
    }

}

