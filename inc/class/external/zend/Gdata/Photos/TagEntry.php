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
 * @subpackage Photos
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: TagEntry.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Entry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Entry.php';

/**
 * @see zend_Gdata_Photos_Extension_Weight
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Photos/Extension/Weight.php';

/**
 * @see zend_Gdata_App_Extension_Category
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/Extension/Category.php';

/**
 * Data model class for a Tag Entry.
 *
 * To transfer user entries to and from the servers, including
 * creating new entries, refer to the service class,
 * zend_Gdata_Photos.
 *
 * This class represents <atom:entry> in the Google Data protocol.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Photos
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Photos_TagEntry extends zend_Gdata_Entry
{

    protected $_entryClassName = 'zend_Gdata_Photos_TagEntry';

    protected $_gphotoWeight = null;

    /**
     * Create a new instance.
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Photos::$namespaces);
        parent::__construct($element);

        $category = new zend_Gdata_App_Extension_Category(
            'http://schemas.google.com/photos/2007#tag',
            'http://schemas.google.com/g/2005#kind');
        $this->setCategory(array($category));
    }

    /**
     * Retrieves a DOMElement which corresponds to this element and all
     * child properties.  This is used to build an entry back into a DOM
     * and eventually XML text for application storage/persistence.
     *
     * @param DOMDocument $doc The DOMDocument used to construct DOMElements
     * @return DOMElement The DOMElement representing this element and all
     *          child properties.
     */
    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_gphotoWeight !== null) {
            $element->appendChild($this->_gphotoWeight->getDOM($element->ownerDocument));
        }
        return $element;
    }

    /**
     * Creates individual Entry objects of the appropriate type and
     * stores them as members of this entry based upon DOM data.
     *
     * @param DOMNode $child The DOMNode to process
     */
    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;

        switch ($absoluteNodeName) {
            case $this->lookupNamespace('gphoto') . ':' . 'weight';
                $weight = new zend_Gdata_Photos_Extension_Weight();
                $weight->transferFromDOM($child);
                $this->_gphotoWeight = $weight;
                break;
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    /**
     * Get the value for this element's gphoto:weight attribute.
     *
     * @see setGphotoWeight
     * @return string The requested attribute.
     */
    public function getGphotoWeight()
    {
        return $this->_gphotoWeight;
    }

    /**
     * Set the value for this element's gphoto:weight attribute.
     *
     * @param string $value The desired value for this attribute.
     * @return zend_Gdata_Photos_Extension_Weight The element being modified.
     */
    public function setGphotoWeight($value)
    {
        $this->_gphotoWeight = $value;
        return $this;
    }
}
