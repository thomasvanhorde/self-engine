<?php

/**
 * Handles connection to a MySQL server.
 *
 * @author  Thomas Van Horde
 * @author  Fabien Nouaillat
 * @package self-engine
 */
class BddMysql
{
    /**
     * @todo Make this property private or protected and use the getter below.
     */
    public $_connexion;

    /**
     * Constructor. Sets the MySQL connection.
     *
     * @todo Do not use the constants anymore. Give them as parameters of the
     *       constructor (e.g. public function __construct($host, $dbname)
     */
    public function __construct()
    {
        $db = mysql_connect(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PWD);
        mysql_select_db(MYSQL_BASE, $db);
        $this->_connexion = new BddMysqlCM();
    }

    /**
     * Returns the current database access.
     *
     * @return BddMysqlCM Object
     */
     public function getConnection()
     {
         return $this->_connection;
     }
}

/* -----------------------------------------------------------------------------
  ~ Aenyhm's thoughts ~

  WTF?!! Give me PDO!

  And as for Mongo, you don't need a class to do the job:

  $mysqlPdoConnection = function ($host, $dbname, $port, $user, $pwd) {
    return new \PDO(
      sprintf('mysql:host=%s;port=%u;dbname=%s', $host, $port, $dbname),
      $user, $pwd, array(
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
      )
    );
  );

  Or make an abstract parent for both MySQL and MongoDB.


  Last but not least: one class per file please.
----------------------------------------------------------------------------- */


/**
 * CRUD implementation using MySQL for the Content Manager.
 *
 * @author  Thomas Van Horde
 * @author  Fabien Nouaillat
 * @version 1.0.1
 * @package self-engine
 */
class BddMysqlCM
{
    const Table_object = 'contentmanager';
    const Table_data = 'contentmanager_data';

    private $_collection;
    private $_sort;
    private $_limit;

    public $_requestArray;

    /**
     * Enregistre les données d'un formulaire.
     *
     * @param  array $dataArray Donnée à enregistrer
     *
     * @return bool
     */
    public function insert($dataArray)
    {
        if ($this->_collection == 'ContentManager')
        {
            $ObjectId = uniqid(true, true);
            $this->request("
                INSERT INTO `".self::Table_object."` (`_id`, `collection`)
                VALUES ('".$ObjectId."', '".$dataArray['collection']."')
            ");
            unset($dataArray['collection']);

            return $this->insertCM($ObjectId, $dataArray);
        }
    }

    /**
     * Met à jours les données.
     *
     * @param  $ObjectId
     * @param  $dataArray
     *
     * @return bool
     */
    public function update($ObjectId, $dataArray)
    {
        unset($dataArray['collection']);
        $this->removeData($ObjectId);
        if ($this->insertCM($ObjectId, $dataArray)) {
            return true;
        }
    }

    /**
     * Supprime les données.
     *
     * @param  $ObjectId
     *
     * @return array|resource
     */
    public function remove($ObjectId)
    {
        $this->request("
            DELETE FROM ".self::Table_data."
            WHERE contentmanager_id='".$ObjectId."'
        ");

        return $this->removeObject($ObjectId);
    }

    /**
     * Supprime les données d'un enregistrement.
     *
     * @param  $ObjectId
     *
     * @return array|resource
     */
    private function removeData($ObjectId)
    {
        return $this->request("
            DELETE FROM ".self::Table_data."
            WHERE contentmanager_id='".$ObjectId."'
        ");
    }

    /**
     * Supprime l'objet.
     *
     * @param  $ObjectId
     *
     * @return array|resource
     */
    private function removeObject($ObjectId)
    {
        return $this->request("
            DELETE FROM ".self::Table_object."
            WHERE _id='".$ObjectId."'
        ");
    }

    /**
     * Sauvegarde les données d'un objet.
     *
     * @param  $ObjectId
     * @param  $dataArray
     *
     * @return bool
     */
    private function insertCM($ObjectId, $dataArray)
    {
        if (is_array($dataArray)) {
            foreach ($dataArray as $key => $data) {
                if (!empty($data)) {
                    if (!is_array($data)) {
                        $this->request("
                            INSERT INTO `".self::Table_data."` (`_id`, `parent_id`, `contentmanager_id`, `field`, `value`)
                            VALUES (NULL, '0', '".$ObjectId."', '".$key."', '".addslashes($data)."');
                        ");
                    } else {
                        $this->insertCM($ObjectId, $data);
                    }
                }
            }
            return true;
        }
    }

    /**
     * Sélectionne une structure.
     *
     * @param  $collection
     *
     * @return This Object
     */
    public function selectCollection($collection)
    {
        $this->_collection = $collection;

        return $this;
    }

    /**
     * Retrouve une liste d'objets.
     *
     * @param  bool  $param
     *
     * @return Object
     */
    public function find($param = false)
    {
        $query = '
            SELECT *
            FROM '.self::Table_object.' as CM, '.self::Table_data.' as CMD
            WHERE CM._id = CMD.contentmanager_id
        ';

        if (!$param) {
            $data = $this->request($query);
        } else {
            /* Listes des paramètres */
            if (isset($param['collection']))
                $query .= ' AND CM.collection = "'.$param['collection'].'"';

            if (isset($param['sort']))
                $query .= $param['sort'];

            if (isset($param['limit']))
                $query .= $param['limit'];

            $data = $this->request($query);
        }

        return (object)$data;
    }

    /**
     * Retrouve un objet.
     *
     * @param  $id
     * @return ?
     */
    public function findOne($id)
    {
        $data = $this->request('
            SELECT *
            FROM '.self::Table_object.' as CM, '.self::Table_data.' as CMD
            WHERE CM._id = CMD.contentmanager_id
            AND CM._id = "'.$id.'"
        ');

        return $data[$id];
    }

    /**
     * Effectue les requêtes SQL.
     *
     * @todo   Make it private.
     *
     * @param  $request
     *
     * @return array|resource
     */
    public function request($request){
        $this->requestArray[] = $request;
        $myData = array();

        $req = mysql_query($request)
            or die('Erreur SQL !<br>'.$request.'<br>'.mysql_error());

        if (is_bool($req)) {
            return $req;
        }

        while ($data = mysql_fetch_assoc($req)) {
            foreach ($data as $d) {
                $myData[$data['contentmanager_id']]['_id'] = $data['contentmanager_id'];
                $myData[$data['contentmanager_id']]['collection'] = $data['collection'];
                $myData[$data['contentmanager_id']][$data['field']] = $data['value'];
            }
        }

        return (array)$myData;
    }

    public function execute()
    {
        $param = array();
        if (!empty($this->_sort)) {
            $param['sort'] = ' ORDER BY '.$this->_sort[0];
            if ($this->_sort[1] == 1)
                $param['sort'] .= ' ASC';
            else
                $param['sort'] .= ' DESC';
        }
        if (!empty($this->_limit)) {
            $param['limit'] = ' LIMIT '.$this->_limit;
        }

        return $this->find($param);
    }

    public function setSort($filter)
    {
        $this->_sort = $filter;
    }

    public function setLimit($limit)
    {
        $this->_limit = $limit;
    }
}