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
 * @version    $Id: Calendar.php 23805 2011-03-16 00:55:40Z tjohns $
 */

/**
 * @see zend_Gdata
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata.php';

/**
 * @see zend_Gdata_Calendar_EventFeed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Calendar/EventFeed.php';

/**
 * @see zend_Gdata_Calendar_EventEntry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Calendar/EventEntry.php';

/**
 * @see zend_Gdata_Calendar_ListFeed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Calendar/ListFeed.php';

/**
 * @see zend_Gdata_Calendar_ListEntry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Calendar/ListEntry.php';

/**
 * Service class for interacting with the Google Calendar data API
 * @link http://code.google.com/apis/gdata/calendar.html
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Calendar
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Calendar extends zend_Gdata
{

    const CALENDAR_FEED_URI = 'https://www.google.com/calendar/feeds';
    const CALENDAR_EVENT_FEED_URI = 'https://www.google.com/calendar/feeds/default/private/full';
    const AUTH_SERVICE_NAME = 'cl';

    protected $_defaultPostUri = self::CALENDAR_EVENT_FEED_URI;

    /**
     * Namespaces used for zend_Gdata_Calendar
     *
     * @var array
     */
    public static $namespaces = array(
        array('gCal', 'http://schemas.google.com/gCal/2005', 1, 0)
    );

    /**
     * Create Gdata_Calendar object
     *
     * @param zend_Http_Client $client (optional) The HTTP client to use when
     *          when communicating with the Google servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('zend_Gdata_Calendar');
        $this->registerPackage('zend_Gdata_Calendar_Extension');
        parent::__construct($client, $applicationId);
        $this->_httpClient->setParameterPost('service', self::AUTH_SERVICE_NAME);
    }

    /**
     * Retreive feed object
     *
     * @param mixed $location The location for the feed, as a URL or Query
     * @return zend_Gdata_Calendar_EventFeed
     */
    public function getCalendarEventFeed($location = null)
    {
        if ($location == null) {
            $uri = self::CALENDAR_EVENT_FEED_URI;
        } else if ($location instanceof zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getFeed($uri, 'zend_Gdata_Calendar_EventFeed');
    }

    /**
     * Retreive entry object
     *
     * @return zend_Gdata_Calendar_EventEntry
     */
    public function getCalendarEventEntry($location = null)
    {
        if ($location == null) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
            throw new zend_Gdata_App_InvalidArgumentException(
                    'Location must not be null');
        } else if ($location instanceof zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'zend_Gdata_Calendar_EventEntry');
    }


    /**
     * Retrieve feed object
     *
     * @return zend_Gdata_Calendar_ListFeed
     */
    public function getCalendarListFeed()
    {
        $uri = self::CALENDAR_FEED_URI . '/default';
        return parent::getFeed($uri,'zend_Gdata_Calendar_ListFeed');
    }

    /**
     * Retreive entryobject
     *
     * @return zend_Gdata_Calendar_ListEntry
     */
    public function getCalendarListEntry($location = null)
    {
        if ($location == null) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
            throw new zend_Gdata_App_InvalidArgumentException(
                    'Location must not be null');
        } else if ($location instanceof zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri,'zend_Gdata_Calendar_ListEntry');
    }

    public function insertEvent($event, $uri=null)
    {
        if ($uri == null) {
            $uri = $this->_defaultPostUri;
        }
        $newEvent = $this->insertEntry($event, $uri, 'zend_Gdata_Calendar_EventEntry');
        return $newEvent;
    }

}
