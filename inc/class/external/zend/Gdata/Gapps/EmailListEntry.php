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
 * @subpackage Gapps
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: EmailListEntry.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Entry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Entry.php';

/**
 * @see zend_Gdata_Extension_FeedLink
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Extension/FeedLink.php';

/**
 * @see zend_Gdata_Gapps_Extension_EmailList
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Gapps/Extension/EmailList.php';

/**
 * Data model class for a Google Apps Email List Entry.
 *
 * Each email list entry describes a single email list within a Google Apps
 * hosted domain. Email lists may contain multiple recipients, as
 * described by instances of zend_Gdata_Gapps_EmailListRecipient. Multiple
 * entries are contained within instances of zend_Gdata_Gapps_EmailListFeed.
 *
 * To transfer email list entries to and from the Google Apps servers,
 * including creating new entries, refer to the Google Apps service class,
 * zend_Gdata_Gapps.
 *
 * This class represents <atom:entry> in the Google Data protocol.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Gapps
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Gapps_EmailListEntry extends zend_Gdata_Entry
{

    protected $_entryClassName = 'zend_Gdata_Gapps_EmailListEntry';

    /**
     * <apps:emailList> child element containing general information about
     * this email list.
     *
     * @var zend_Gdata_Gapps_Extension_EmailList
     */
    protected $_emailList = null;

    /**
     * <gd:feedLink> element containing information about other feeds
     * relevant to this entry.
     *
     * @var zend_Gdata_Extension_FeedLink
     */
    protected $_feedLink = array();

    /**
     * Create a new instance.
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Gapps::$namespaces);
        parent::__construct($element);
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
        if ($this->_emailList !== null) {
            $element->appendChild($this->_emailList->getDOM($element->ownerDocument));
        }
        foreach ($this->_feedLink as $feedLink) {
            $element->appendChild($feedLink->getDOM($element->ownerDocument));
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
            case $this->lookupNamespace('apps') . ':' . 'emailList';
                $emailList = new zend_Gdata_Gapps_Extension_EmailList();
                $emailList->transferFromDOM($child);
                $this->_emailList = $emailList;
                break;
            case $this->lookupNamespace('gd') . ':' . 'feedLink';
                $feedLink = new zend_Gdata_Extension_FeedLink();
                $feedLink->transferFromDOM($child);
                $this->_feedLink[] = $feedLink;
                break;
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    /**
     * Retrieve the email list property for this entry.
     *
     * @see setEmailList
     * @return zend_Gdata_Gapps_Extension_EmailList The requested object
     *              or null if not set.
     */
    public function getEmailList()
    {
        return $this->_emailList;
    }

    /**
     * Set the email list property for this entry. This property contains
     * information such as the name of this email list.
     *
     * This corresponds to the <apps:emailList> property in the Google Data
     * protocol.
     *
     * @param zend_Gdata_Gapps_Extension_EmailList $value The desired value
     *              this element, or null to unset.
     * @return zend_Gdata_Gapps_EventEntry Provides a fluent interface
     */
    public function setEmailList($value)
    {
        $this->_emailList = $value;
        return $this;
    }

    /**
     * Get the feed link property for this entry.
     *
     * @see setFeedLink
     * @param string $rel (optional) The rel value of the link to be found.
     *          If null, the array of links is returned.
     * @return mixed If $rel is specified, a zend_Gdata_Extension_FeedLink
     *          object corresponding to the requested rel value is returned
     *          if found, or null if the requested value is not found. If
     *          $rel is null or not specified, an array of all available
     *          feed links for this entry is returned, or null if no feed
     *          links are set.
     */
    public function getFeedLink($rel = null)
    {
        if ($rel == null) {
            return $this->_feedLink;
        } else {
            foreach ($this->_feedLink as $feedLink) {
                if ($feedLink->rel == $rel) {
                    return $feedLink;
                }
            }
            return null;
        }
    }

    /**
     * Set the feed link property for this entry. Feed links provide
     * information about other feeds associated with this entry.
     *
     * This corresponds to the <gd:feedLink> property in the Google Data
     * protocol.
     *
     * @param array $value A collection of zend_Gdata_Gapps_Extension_FeedLink
     *          instances representing all feed links for this entry, or
     *          null to unset.
     * @return zend_Gdata_Gapps_EventEntry Provides a fluent interface
     */
    public function setFeedLink($value)
    {
        $this->_feedLink = $value;
        return $this;
    }

}
