<?php

/**
 * zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Geo
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Entry.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Entry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Entry.php';

/**
 * @see zend_Gdata_Geo
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Geo.php';

/**
 * @see zend_Gdata_Geo_Extension_GeoRssWhere
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Geo/Extension/GeoRssWhere.php';

/**
 * An Atom entry containing Geograpic data.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Geo
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Geo_Entry extends zend_Gdata_Entry
{

    protected $_entryClassName = 'zend_Gdata_Geo_Entry';

    protected $_where = null;

    public function __construct($element = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Geo::$namespaces);
        parent::__construct($element);
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_where != null) {
            $element->appendChild($this->_where->getDOM($element->ownerDocument));
        }
        return $element;
    }

    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        case $this->lookupNamespace('georss') . ':' . 'where':
            $where = new zend_Gdata_Geo_Extension_GeoRssWhere();
            $where->transferFromDOM($child);
            $this->_where = $where;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    public function getWhere()
    {
        return $this->_where;
    }

    public function setWhere($value)
    {
        $this->_where = $value;
        return $this;
    }


}
