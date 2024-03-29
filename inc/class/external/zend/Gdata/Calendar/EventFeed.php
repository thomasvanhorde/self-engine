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
 * @subpackage Calendar
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: EventFeed.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Feed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Feed.php';

/**
 * @see zend_Gdata_Extension_Timezone
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Calendar/Extension/Timezone.php';

/**
 * Data model for a Google Calendar feed of events
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Calendar
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Calendar_EventFeed extends zend_Gdata_Feed
{

    protected $_timezone = null;

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'zend_Gdata_Calendar_EventEntry';

    /**
     * The classname for the feed.
     *
     * @var string
     */
    protected $_feedClassName = 'zend_Gdata_Calendar_EventFeed';

    public function __construct($element = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Calendar::$namespaces);
        parent::__construct($element);
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_timezone != null) {
            $element->appendChild($this->_timezone->getDOM($element->ownerDocument));
        }

        return $element;
    }

    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;

        switch ($absoluteNodeName) {
            case $this->lookupNamespace('gCal') . ':' . 'timezone';
                $timezone = new zend_Gdata_Calendar_Extension_Timezone();
                $timezone->transferFromDOM($child);
                $this->_timezone = $timezone;
                break;

            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    public function getTimezone()
    {
        return $this->_timezone;
    }

    public function setTimezone($value)
    {
        $this->_timezone = $value;
        return $this;
    }

}
