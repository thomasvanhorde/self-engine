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
 * @version    $Id: UserFeed.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Photos
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Photos.php';

/**
 * @see zend_Gdata_Feed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Feed.php';

/**
 * @see zend_Gdata_Photos_UserEntry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Photos/UserEntry.php';

/**
 * @see zend_Gdata_Photos_AlbumEntry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Photos/AlbumEntry.php';

/**
 * @see zend_Gdata_Photos_PhotoEntry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Photos/PhotoEntry.php';

/**
 * @see zend_Gdata_Photos_TagEntry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Photos/TagEntry.php';

/**
 * @see zend_Gdata_Photos_CommentEntry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Photos/CommentEntry.php';

/**
 * Data model for a collection of entries for a specific user, usually
 * provided by the servers.
 *
 * For information on requesting this feed from a server, see the
 * service class, zend_Gdata_Photos.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Photos
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Photos_UserFeed extends zend_Gdata_Feed
{

    /**
     * gphoto:user element
     *
     * @var zend_Gdata_Photos_Extension_User
     */
    protected $_gphotoUser = null;

    /**
     * gphoto:thumbnail element
     *
     * @var zend_Gdata_Photos_Extension_Thumbnail
     */
    protected $_gphotoThumbnail = null;

    /**
     * gphoto:nickname element
     *
     * @var zend_Gdata_Photos_Extension_Nickname
     */
    protected $_gphotoNickname = null;

    protected $_entryClassName = 'zend_Gdata_Photos_UserEntry';
    protected $_feedClassName = 'zend_Gdata_Photos_UserFeed';

    protected $_entryKindClassMapping = array(
        'http://schemas.google.com/photos/2007#album' => 'zend_Gdata_Photos_AlbumEntry',
        'http://schemas.google.com/photos/2007#photo' => 'zend_Gdata_Photos_PhotoEntry',
        'http://schemas.google.com/photos/2007#comment' => 'zend_Gdata_Photos_CommentEntry',
        'http://schemas.google.com/photos/2007#tag' => 'zend_Gdata_Photos_TagEntry'
    );

    public function __construct($element = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Photos::$namespaces);
        parent::__construct($element);
    }

    /**
     * Creates individual Entry objects of the appropriate type and
     * stores them in the $_entry array based upon DOM data.
     *
     * @param DOMNode $child The DOMNode to process
     */
    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
            case $this->lookupNamespace('gphoto') . ':' . 'user';
                $user = new zend_Gdata_Photos_Extension_User();
                $user->transferFromDOM($child);
                $this->_gphotoUser = $user;
                break;
            case $this->lookupNamespace('gphoto') . ':' . 'nickname';
                $nickname = new zend_Gdata_Photos_Extension_Nickname();
                $nickname->transferFromDOM($child);
                $this->_gphotoNickname = $nickname;
                break;
            case $this->lookupNamespace('gphoto') . ':' . 'thumbnail';
                $thumbnail = new zend_Gdata_Photos_Extension_Thumbnail();
                $thumbnail->transferFromDOM($child);
                $this->_gphotoThumbnail = $thumbnail;
                break;
            case $this->lookupNamespace('atom') . ':' . 'entry':
                $entryClassName = $this->_entryClassName;
                $tmpEntry = new zend_Gdata_App_Entry($child);
                $categories = $tmpEntry->getCategory();
                foreach ($categories as $category) {
                    if ($category->scheme == zend_Gdata_Photos::KIND_PATH &&
                        $this->_entryKindClassMapping[$category->term] != "") {
                            $entryClassName = $this->_entryKindClassMapping[$category->term];
                            break;
                    } else {
                        require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/Exception.php';
                        throw new zend_Gdata_App_Exception('Entry is missing kind declaration.');
                    }
                }

                $newEntry = new $entryClassName($child);
                $newEntry->setHttpClient($this->getHttpClient());
                $this->_entry[] = $newEntry;
                break;
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_gphotoUser != null) {
            $element->appendChild($this->_gphotoUser->getDOM($element->ownerDocument));
        }
        if ($this->_gphotoNickname != null) {
            $element->appendChild($this->_gphotoNickname->getDOM($element->ownerDocument));
        }
        if ($this->_gphotoThumbnail != null) {
            $element->appendChild($this->_gphotoThumbnail->getDOM($element->ownerDocument));
        }

        return $element;
    }

    /**
     * Get the value for this element's gphoto:user attribute.
     *
     * @see setGphotoUser
     * @return string The requested attribute.
     */
    public function getGphotoUser()
    {
        return $this->_gphotoUser;
    }

    /**
     * Set the value for this element's gphoto:user attribute.
     *
     * @param string $value The desired value for this attribute.
     * @return zend_Gdata_Photos_Extension_User The element being modified.
     */
    public function setGphotoUser($value)
    {
        $this->_gphotoUser = $value;
        return $this;
    }

    /**
     * Get the value for this element's gphoto:nickname attribute.
     *
     * @see setGphotoNickname
     * @return string The requested attribute.
     */
    public function getGphotoNickname()
    {
        return $this->_gphotoNickname;
    }

    /**
     * Set the value for this element's gphoto:nickname attribute.
     *
     * @param string $value The desired value for this attribute.
     * @return zend_Gdata_Photos_Extension_Nickname The element being modified.
     */
    public function setGphotoNickname($value)
    {
        $this->_gphotoNickname = $value;
        return $this;
    }

    /**
     * Get the value for this element's gphoto:thumbnail attribute.
     *
     * @see setGphotoThumbnail
     * @return string The requested attribute.
     */
    public function getGphotoThumbnail()
    {
        return $this->_gphotoThumbnail;
    }

    /**
     * Set the value for this element's gphoto:thumbnail attribute.
     *
     * @param string $value The desired value for this attribute.
     * @return zend_Gdata_Photos_Extension_Thumbnail The element being modified.
     */
    public function setGphotoThumbnail($value)
    {
        $this->_gphotoThumbnail = $value;
        return $this;
    }

}
