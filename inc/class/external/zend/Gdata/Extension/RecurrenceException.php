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
 * @subpackage Gdata
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: RecurrenceException.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Extension
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Extension.php';

/**
 * @see zend_Gdata_Extension_EntryLink
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Extension/EntryLink.php';

/**
 * @see zend_Gdata_Extension_OriginalEvent
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Extension/OriginalEvent.php';

/**
 * Data model class to represent an entry's recurrenceException
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Gdata
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Extension_RecurrenceException extends zend_Gdata_Extension
{

    protected $_rootElement = 'recurrenceException';
    protected $_specialized = null;
    protected $_entryLink = null;
    protected $_originalEvent = null;

    /**
     * Constructs a new zend_Gdata_Extension_RecurrenceException object.
     * @param bool $specialized (optional) Whether this is a specialized exception or not.
     * @param zend_Gdata_EntryLink (optional) An Event entry with details about the exception.
     * @param zend_Gdata_OriginalEvent (optional) The origianl recurrent event this is an exeption to.
     */
    public function __construct($specialized = null, $entryLink = null,
            $originalEvent = null)
    {
        parent::__construct();
        $this->_specialized = $specialized;
        $this->_entryLink = $entryLink;
        $this->_originalEvent = $originalEvent;
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
        if ($this->_specialized !== null) {
            $element->setAttribute('specialized', ($this->_specialized ? "true" : "false"));
        }
        if ($this->_entryLink !== null) {
            $element->appendChild($this->_entryLink->getDOM($element->ownerDocument));
        }
        if ($this->_originalEvent !== null) {
            $element->appendChild($this->_originalEvent->getDOM($element->ownerDocument));
        }
        return $element;
    }

    /**
     * Given a DOMNode representing an attribute, tries to map the data into
     * instance members.  If no mapping is defined, the name and value are
     * stored in an array.
     *
     * @param DOMNode $attribute The DOMNode attribute needed to be handled
     */
    protected function takeAttributeFromDOM($attribute)
    {
        switch ($attribute->localName) {
        case 'specialized':
            if ($attribute->nodeValue == "true") {
                $this->_specialized = true;
            }
            else if ($attribute->nodeValue == "false") {
                $this->_specialized = false;
            }
            else {
                throw new zend_Gdata_App_InvalidArgumentException("Expected 'true' or 'false' for gCal:selected#value.");
            }
            break;
        default:
            parent::takeAttributeFromDOM($attribute);
        }
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
        case $this->lookupNamespace('gd') . ':' . 'entryLink':
            $entryLink = new zend_Gdata_Extension_EntryLink();
            $entryLink->transferFromDOM($child);
            $this->_entryLink = $entryLink;
            break;
        case $this->lookupNamespace('gd') . ':' . 'originalEvent':
            $originalEvent = new zend_Gdata_Extension_OriginalEvent();
            $originalEvent->transferFromDOM($child);
            $this->_originalEvent = $originalEvent;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    /**
     * Get the value for this element's Specialized attribute.
     *
     * @return bool The requested attribute.
     */
    public function getSpecialized()
    {
        return $this->_specialized;
    }

    /**
     * Set the value for this element's Specialized attribute.
     *
     * @param bool $value The desired value for this attribute.
     * @return zend_Gdata_Extension_RecurrenceException The element being modified.
     */
    public function setSpecialized($value)
    {
        $this->_specialized = $value;
        return $this;
    }

    /**
     * Get the value for this element's EntryLink attribute.
     *
     * @return zend_Gdata_Extension_EntryLink The requested attribute.
     */
    public function getEntryLink()
    {
        return $this->_entryLink;
    }

    /**
     * Set the value for this element's EntryLink attribute.
     *
     * @param zend_Gdata_Extension_EntryLink $value The desired value for this attribute.
     * @return zend_Gdata_Extension_RecurrenceException The element being modified.
     */
    public function setEntryLink($value)
    {
        $this->_entryLink = $value;
        return $this;
    }

    /**
     * Get the value for this element's Specialized attribute.
     *
     * @return zend_Gdata_Extension_OriginalEvent The requested attribute.
     */
    public function getOriginalEvent()
    {
        return $this->_originalEvent;
    }

    /**
     * Set the value for this element's Specialized attribute.
     *
     * @param zend_Gdata_Extension_OriginalEvent $value The desired value for this attribute.
     * @return zend_Gdata_Extension_RecurrenceException The element being modified.
     */
    public function setOriginalEvent($value)
    {
        $this->_originalEvent = $value;
        return $this;
    }

}

