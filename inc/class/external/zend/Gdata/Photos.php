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
 * @version    $Id: Photos.php 23805 2011-03-16 00:55:40Z tjohns $
 */

/**
 * @see zend_Gdata
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata.php';

/**
 * @see zend_Gdata_Photos_UserFeed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Photos/UserFeed.php';

/**
 * @see zend_Gdata_Photos_AlbumFeed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Photos/AlbumFeed.php';

/**
 * @see zend_Gdata_Photos_PhotoFeed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Photos/PhotoFeed.php';

/**
 * Service class for interacting with the Google Photos Data API.
 *
 * Like other service classes in this module, this class provides access via
 * an HTTP client to Google servers for working with entries and feeds.
 *
 * @link http://code.google.com/apis/picasaweb/gdata.html
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Photos
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Photos extends zend_Gdata
{

    const PICASA_BASE_URI = 'https://picasaweb.google.com/data';
    const PICASA_BASE_FEED_URI = 'https://picasaweb.google.com/data/feed';
    const AUTH_SERVICE_NAME = 'lh2';

    /**
     * Default projection when interacting with the Picasa server.
     */
    const DEFAULT_PROJECTION = 'api';

    /**
     * The default visibility to filter events by.
     */
    const DEFAULT_VISIBILITY = 'all';

    /**
     * The default user to retrieve feeds for.
     */
    const DEFAULT_USER = 'default';

    /**
     * Path to the user feed on the Picasa server.
     */
    const USER_PATH = 'user';

    /**
     * Path to album feeds on the Picasa server.
     */
    const ALBUM_PATH = 'albumid';

    /**
     * Path to photo feeds on the Picasa server.
     */
    const PHOTO_PATH = 'photoid';

    /**
     * The path to the community search feed on the Picasa server.
     */
    const COMMUNITY_SEARCH_PATH = 'all';

    /**
     * The path to use for finding links to feeds within entries
     */
    const FEED_LINK_PATH = 'http://schemas.google.com/g/2005#feed';

    /**
     * The path to use for the determining type of an entry
     */
    const KIND_PATH = 'http://schemas.google.com/g/2005#kind';

    /**
     * Namespaces used for zend_Gdata_Photos
     *
     * @var array
     */
    public static $namespaces = array(
        array('gphoto', 'http://schemas.google.com/photos/2007', 1, 0),
        array('photo', 'http://www.pheed.com/pheed/', 1, 0),
        array('exif', 'http://schemas.google.com/photos/exif/2007', 1, 0),
        array('georss', 'http://www.georss.org/georss', 1, 0),
        array('gml', 'http://www.opengis.net/gml', 1, 0),
        array('media', 'http://search.yahoo.com/mrss/', 1, 0)
    );

    /**
     * Create zend_Gdata_Photos object
     *
     * @param zend_Http_Client $client (optional) The HTTP client to use when
     *          when communicating with the servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('zend_Gdata_Photos');
        $this->registerPackage('zend_Gdata_Photos_Extension');
        parent::__construct($client, $applicationId);
        $this->_httpClient->setParameterPost('service', self::AUTH_SERVICE_NAME);
    }

    /**
     * Retrieve a UserFeed containing AlbumEntries, PhotoEntries and
     * TagEntries associated with a given user.
     *
     * @param string $userName The userName of interest
     * @param mixed $location (optional) The location for the feed, as a URL
     *          or Query. If not provided, a default URL will be used instead.
     * @return zend_Gdata_Photos_UserFeed
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function getUserFeed($userName = null, $location = null)
    {
        if ($location instanceof zend_Gdata_Photos_UserQuery) {
            $location->setType('feed');
            if ($userName !== null) {
                $location->setUser($userName);
            }
            $uri = $location->getQueryUrl();
        } else if ($location instanceof zend_Gdata_Query) {
            if ($userName !== null) {
                $location->setUser($userName);
            }
            $uri = $location->getQueryUrl();
        } else if ($location !== null) {
            $uri = $location;
        } else if ($userName !== null) {
            $uri = self::PICASA_BASE_FEED_URI . '/' .
                self::DEFAULT_PROJECTION . '/' . self::USER_PATH . '/' .
                $userName;
        } else {
            $uri = self::PICASA_BASE_FEED_URI . '/' .
                self::DEFAULT_PROJECTION . '/' . self::USER_PATH . '/' .
                self::DEFAULT_USER;
        }

        return parent::getFeed($uri, 'zend_Gdata_Photos_UserFeed');
    }

    /**
     * Retreive AlbumFeed object containing multiple PhotoEntry or TagEntry
     * objects.
     *
     * @param mixed $location (optional) The location for the feed, as a URL or Query.
     * @return zend_Gdata_Photos_AlbumFeed
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function getAlbumFeed($location = null)
    {
        if ($location === null) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
            throw new zend_Gdata_App_InvalidArgumentException(
                    'Location must not be null');
        } else if ($location instanceof zend_Gdata_Photos_UserQuery) {
            $location->setType('feed');
            $uri = $location->getQueryUrl();
        } else if ($location instanceof zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getFeed($uri, 'zend_Gdata_Photos_AlbumFeed');
    }

    /**
     * Retreive PhotoFeed object containing comments and tags associated
     * with a given photo.
     *
     * @param mixed $location (optional) The location for the feed, as a URL
     *          or Query. If not specified, the community search feed will
     *          be returned instead.
     * @return zend_Gdata_Photos_PhotoFeed
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function getPhotoFeed($location = null)
    {
        if ($location === null) {
            $uri = self::PICASA_BASE_FEED_URI . '/' .
                self::DEFAULT_PROJECTION . '/' .
                self::COMMUNITY_SEARCH_PATH;
        } else if ($location instanceof zend_Gdata_Photos_UserQuery) {
            $location->setType('feed');
            $uri = $location->getQueryUrl();
        } else if ($location instanceof zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getFeed($uri, 'zend_Gdata_Photos_PhotoFeed');
    }

    /**
     * Retreive a single UserEntry object.
     *
     * @param mixed $location The location for the feed, as a URL or Query.
     * @return zend_Gdata_Photos_UserEntry
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function getUserEntry($location)
    {
        if ($location === null) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
            throw new zend_Gdata_App_InvalidArgumentException(
                    'Location must not be null');
        } else if ($location instanceof zend_Gdata_Photos_UserQuery) {
            $location->setType('entry');
            $uri = $location->getQueryUrl();
        } else if ($location instanceof zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'zend_Gdata_Photos_UserEntry');
    }

    /**
     * Retreive a single AlbumEntry object.
     *
     * @param mixed $location The location for the feed, as a URL or Query.
     * @return zend_Gdata_Photos_AlbumEntry
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function getAlbumEntry($location)
    {
        if ($location === null) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
            throw new zend_Gdata_App_InvalidArgumentException(
                    'Location must not be null');
        } else if ($location instanceof zend_Gdata_Photos_UserQuery) {
            $location->setType('entry');
            $uri = $location->getQueryUrl();
        } else if ($location instanceof zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'zend_Gdata_Photos_AlbumEntry');
    }

    /**
     * Retreive a single PhotoEntry object.
     *
     * @param mixed $location The location for the feed, as a URL or Query.
     * @return zend_Gdata_Photos_PhotoEntry
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function getPhotoEntry($location)
    {
        if ($location === null) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
            throw new zend_Gdata_App_InvalidArgumentException(
                    'Location must not be null');
        } else if ($location instanceof zend_Gdata_Photos_UserQuery) {
            $location->setType('entry');
            $uri = $location->getQueryUrl();
        } else if ($location instanceof zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'zend_Gdata_Photos_PhotoEntry');
    }

    /**
     * Retreive a single TagEntry object.
     *
     * @param mixed $location The location for the feed, as a URL or Query.
     * @return zend_Gdata_Photos_TagEntry
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function getTagEntry($location)
    {
        if ($location === null) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
            throw new zend_Gdata_App_InvalidArgumentException(
                    'Location must not be null');
        } else if ($location instanceof zend_Gdata_Photos_UserQuery) {
            $location->setType('entry');
            $uri = $location->getQueryUrl();
        } else if ($location instanceof zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'zend_Gdata_Photos_TagEntry');
    }

    /**
     * Retreive a single CommentEntry object.
     *
     * @param mixed $location The location for the feed, as a URL or Query.
     * @return zend_Gdata_Photos_CommentEntry
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function getCommentEntry($location)
    {
        if ($location === null) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
            throw new zend_Gdata_App_InvalidArgumentException(
                    'Location must not be null');
        } else if ($location instanceof zend_Gdata_Photos_UserQuery) {
            $location->setType('entry');
            $uri = $location->getQueryUrl();
        } else if ($location instanceof zend_Gdata_Query) {
            $uri = $location->getQueryUrl();
        } else {
            $uri = $location;
        }
        return parent::getEntry($uri, 'zend_Gdata_Photos_CommentEntry');
    }

    /**
     * Create a new album from a AlbumEntry.
     *
     * @param zend_Gdata_Photos_AlbumEntry $album The album entry to
     *          insert.
     * @param string $url (optional) The URI that the album should be
     *          uploaded to. If null, the default album creation URI for
     *          this domain will be used.
     * @return zend_Gdata_Photos_AlbumEntry The inserted album entry as
     *          returned by the server.
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function insertAlbumEntry($album, $uri = null)
    {
        if ($uri === null) {
            $uri = self::PICASA_BASE_FEED_URI . '/' .
                self::DEFAULT_PROJECTION . '/' . self::USER_PATH . '/' .
                self::DEFAULT_USER;
        }
        $newEntry = $this->insertEntry($album, $uri, 'zend_Gdata_Photos_AlbumEntry');
        return $newEntry;
    }

    /**
     * Create a new photo from a PhotoEntry.
     *
     * @param zend_Gdata_Photos_PhotoEntry $photo The photo to insert.
     * @param string $url The URI that the photo should be uploaded
     *          to. Alternatively, an AlbumEntry can be provided and the
     *          photo will be added to that album.
     * @return zend_Gdata_Photos_PhotoEntry The inserted photo entry
     *          as returned by the server.
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function insertPhotoEntry($photo, $uri = null)
    {
        if ($uri instanceof zend_Gdata_Photos_AlbumEntry) {
            $uri = $uri->getLink(self::FEED_LINK_PATH)->href;
        }
        if ($uri === null) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
            throw new zend_Gdata_App_InvalidArgumentException(
                    'URI must not be null');
        }
        $newEntry = $this->insertEntry($photo, $uri, 'zend_Gdata_Photos_PhotoEntry');
        return $newEntry;
    }

    /**
     * Create a new tag from a TagEntry.
     *
     * @param zend_Gdata_Photos_TagEntry $tag The tag entry to insert.
     * @param string $url The URI where the tag should be
     *          uploaded to. Alternatively, a PhotoEntry can be provided and
     *          the tag will be added to that photo.
     * @return zend_Gdata_Photos_TagEntry The inserted tag entry as returned
     *          by the server.
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function insertTagEntry($tag, $uri = null)
    {
        if ($uri instanceof zend_Gdata_Photos_PhotoEntry) {
            $uri = $uri->getLink(self::FEED_LINK_PATH)->href;
        }
        if ($uri === null) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
            throw new zend_Gdata_App_InvalidArgumentException(
                    'URI must not be null');
        }
        $newEntry = $this->insertEntry($tag, $uri, 'zend_Gdata_Photos_TagEntry');
        return $newEntry;
    }

    /**
     * Create a new comment from a CommentEntry.
     *
     * @param zend_Gdata_Photos_CommentEntry $comment The comment entry to
     *          insert.
     * @param string $url The URI where the comment should be uploaded to.
     *          Alternatively, a PhotoEntry can be provided and
     *          the comment will be added to that photo.
     * @return zend_Gdata_Photos_CommentEntry The inserted comment entry
     *          as returned by the server.
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function insertCommentEntry($comment, $uri = null)
    {
        if ($uri instanceof zend_Gdata_Photos_PhotoEntry) {
            $uri = $uri->getLink(self::FEED_LINK_PATH)->href;
        }
        if ($uri === null) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
            throw new zend_Gdata_App_InvalidArgumentException(
                    'URI must not be null');
        }
        $newEntry = $this->insertEntry($comment, $uri, 'zend_Gdata_Photos_CommentEntry');
        return $newEntry;
    }

    /**
     * Delete an AlbumEntry.
     *
     * @param zend_Gdata_Photos_AlbumEntry $album The album entry to
     *          delete.
     * @param boolean $catch Whether to catch an exception when
     *            modified and re-delete or throw
     * @return void.
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function deleteAlbumEntry($album, $catch)
    {
        if ($catch) {
            try {
                $this->delete($album);
            } catch (zend_Gdata_App_HttpException $e) {
                if ($e->getResponse()->getStatus() === 409) {
                    $entry = new zend_Gdata_Photos_AlbumEntry($e->getResponse()->getBody());
                    $this->delete($entry->getLink('edit')->href);
                } else {
                    throw $e;
                }
            }
        } else {
            $this->delete($album);
        }
    }

    /**
     * Delete a PhotoEntry.
     *
     * @param zend_Gdata_Photos_PhotoEntry $photo The photo entry to
     *          delete.
     * @param boolean $catch Whether to catch an exception when
     *            modified and re-delete or throw
     * @return void.
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function deletePhotoEntry($photo, $catch)
    {
        if ($catch) {
            try {
                $this->delete($photo);
            } catch (zend_Gdata_App_HttpException $e) {
                if ($e->getResponse()->getStatus() === 409) {
                    $entry = new zend_Gdata_Photos_PhotoEntry($e->getResponse()->getBody());
                    $this->delete($entry->getLink('edit')->href);
                } else {
                    throw $e;
                }
            }
        } else {
            $this->delete($photo);
        }
    }

    /**
     * Delete a CommentEntry.
     *
     * @param zend_Gdata_Photos_CommentEntry $comment The comment entry to
     *          delete.
     * @param boolean $catch Whether to catch an exception when
     *            modified and re-delete or throw
     * @return void.
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function deleteCommentEntry($comment, $catch)
    {
        if ($catch) {
            try {
                $this->delete($comment);
            } catch (zend_Gdata_App_HttpException $e) {
                if ($e->getResponse()->getStatus() === 409) {
                    $entry = new zend_Gdata_Photos_CommentEntry($e->getResponse()->getBody());
                    $this->delete($entry->getLink('edit')->href);
                } else {
                    throw $e;
                }
            }
        } else {
            $this->delete($comment);
        }
    }

    /**
     * Delete a TagEntry.
     *
     * @param zend_Gdata_Photos_TagEntry $tag The tag entry to
     *          delete.
     * @param boolean $catch Whether to catch an exception when
     *            modified and re-delete or throw
     * @return void.
     * @throws zend_Gdata_App_Exception
     * @throws zend_Gdata_App_HttpException
     */
    public function deleteTagEntry($tag, $catch)
    {
        if ($catch) {
            try {
                $this->delete($tag);
            } catch (zend_Gdata_App_HttpException $e) {
                if ($e->getResponse()->getStatus() === 409) {
                    $entry = new zend_Gdata_Photos_TagEntry($e->getResponse()->getBody());
                    $this->delete($entry->getLink('edit')->href);
                } else {
                    throw $e;
                }
            }
        } else {
            $this->delete($tag);
        }
    }

}
