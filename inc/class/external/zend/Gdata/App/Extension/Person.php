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
 * @subpackage App
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Person.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_App_Extension
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/Extension.php';

/**
 * @see zend_Gdata_App_Extension_Name
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/Extension/Name.php';

/**
 * @see zend_Gdata_App_Extension_Email
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/Extension/Email.php';

/**
 * @see zend_Gdata_App_Extension_Uri
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/Extension/Uri.php';

/**
 * Base class for people (currently used by atom:author, atom:contributor)
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage App
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class zend_Gdata_App_Extension_Person extends zend_Gdata_App_Extension
{

    protected $_rootElement = null;
    protected $_name = null;
    protected $_email = null;
    protected $_uri = null;

    public function __construct($name = null, $email = null, $uri = null)
    {
        parent::__construct();
        $this->_name = $name;
        $this->_email = $email;
        $this->_uri = $uri;
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_name != null) {
            $element->appendChild($this->_name->getDOM($element->ownerDocument));
        }
        if ($this->_email != null) {
            $element->appendChild($this->_email->getDOM($element->ownerDocument));
        }
        if ($this->_uri != null) {
            $element->appendChild($this->_uri->getDOM($element->ownerDocument));
        }
        return $element;
    }

    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        case $this->lookupNamespace('atom') . ':' . 'name':
            $name = new zend_Gdata_App_Extension_Name();
            $name->transferFromDOM($child);
            $this->_name = $name;
            break;
        case $this->lookupNamespace('atom') . ':' . 'email':
            $email = new zend_Gdata_App_Extension_Email();
            $email->transferFromDOM($child);
            $this->_email = $email;
            break;
        case $this->lookupNamespace('atom') . ':' . 'uri':
            $uri = new zend_Gdata_App_Extension_Uri();
            $uri->transferFromDOM($child);
            $this->_uri = $uri;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    /**
     * @return zend_Gdata_App_Extension_Name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param zend_Gdata_App_Extension_Name $value
     * @return zend_Gdata_App_Entry Provides a fluent interface
     */
    public function setName($value)
    {
        $this->_name = $value;
        return $this;
    }

    /**
     * @return zend_Gdata_App_Extension_Email
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param zend_Gdata_App_Extension_Email $value
     * @return zend_Gdata_App_Extension_Person Provides a fluent interface
     */
    public function setEmail($value)
    {
        $this->_email = $value;
        return $this;
    }

    /**
     * @return zend_Gdata_App_Extension_Uri
     */
    public function getUri()
    {
        return $this->_uri;
    }

    /**
     * @param zend_Gdata_App_Extension_Uri $value
     * @return zend_Gdata_App_Extension_Person Provides a fluent interface
     */
    public function setUri($value)
    {
        $this->_uri = $value;
        return $this;
    }

}
