<?php

/**
 * Handles connection to a MongoDB server.
 *
 * @author  Thomas Van Horde
 * @author  Fabien Nouaillat
 * @package self-engine
 */
class BddMongoDB
{
    /**
     * @todo Make this property private or protected and use the getter below.
     */
    public $_connexion;

    /**
     * Constructor. Connects to a Mongo database. It requires the MongoDB
     * extension for PHP.
     *
     * @todo Do not use the constants anymore. Give them as parameters of the
     *       constructor (e.g. public function __construct($host, $dbname)
     */
    public function __construct()
    {
        $mongo = new Mongo(MONGO_HOST);
        $this->_connexion = $mongo->selectDB(MONGO_BASE);
    }

    /**
     * Returns the current database access.
     *
     * @return MongoDB Object
     */
     public function getConnection()
     {
         return $this->_connection;
     }
}

/* -----------------------------------------------------------------------------
  ~ Aenyhm's thoughts ~

  You can also do it easier:

  $mongoConnection = function ($host, $dbname) {
    $mongo = new Mongo($host);
    return $mongo->selectDB($dbname);
  };

  Then, just call it like that:

  $dbh = $mongoConnection('mongodb://myserver.com', 'mydb');
----------------------------------------------------------------------------- */