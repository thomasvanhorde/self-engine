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
 * @subpackage Exif
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Entry.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Entry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Entry.php';

/**
 * @see zend_Gdata_Exif
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Exif.php';

/**
 * @see zend_Gdata_Exif_Extension_Tags
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Exif/Extension/Tags.php';

/**
 * An Atom entry containing EXIF metadata.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Exif
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Exif_Entry extends zend_Gdata_Entry
{
    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'zend_Gdata_Exif_Entry';

    /**
     * The tags that belong to the Exif group.
     *
     * @var string
     */
    protected $_tags = null;

    /**
     * Create a new instance.
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Exif::$namespaces);
        parent::__construct($element);
    }

    /**
     * Retrieves a DOMElement which corresponds to this element and all
     * child properties.  This is used to build an entry back into a DOM
     * and eventually XML text for sending to the server upon updates, or
     * for application storage/persistence.
     *
     * @param DOMDocument $doc The DOMDocument used to construct DOMElements
     * @return DOMElement The DOMElement representing this element and all
     * child properties.
     */
    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_tags != null) {
            $element->appendChild($this->_tags->getDOM($element->ownerDocument));
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
        case $this->lookupNamespace('exif') . ':' . 'tags':
            $tags = new zend_Gdata_Exif_Extension_Tags();
            $tags->transferFromDOM($child);
            $this->_tags = $tags;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    /**
     * Retrieve the tags for this entry.
     *
     * @see setTags
     * @return zend_Gdata_Exif_Extension_Tags The requested object
     *              or null if not set.
     */
    public function getTags()
    {
        return $this->_tags;
    }

    /**
     * Set the tags property for this entry. This property contains
     * various Exif data.
     *
     * This corresponds to the <exif:tags> property in the Google Data
     * protocol.
     *
     * @param zend_Gdata_Exif_Extension_Tags $value The desired value
     *              this element, or null to unset.
     * @return zend_Gdata_Exif_Entry Provides a fluent interface
     */
    public function setTags($value)
    {
        $this->_tags = $value;
        return $this;
    }

}
