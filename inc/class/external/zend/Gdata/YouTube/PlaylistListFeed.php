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
 * @subpackage YouTube
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: PlaylistListFeed.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Media_Feed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Media/Feed.php';

/**
 * @see zend_Gdata_YouTube_PlaylistListEntry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/YouTube/PlaylistListEntry.php';

/**
 * The YouTube video playlist flavor of an Atom Feed with media support
 * Represents a list of individual playlists, where each contained entry is
 * a playlist.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage YouTube
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_YouTube_PlaylistListFeed extends zend_Gdata_Media_Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'zend_Gdata_YouTube_PlaylistListEntry';

    /**
     * Creates a Playlist list feed, representing a list of playlists,
     * usually associated with an individual user.
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(zend_Gdata_YouTube::$namespaces);
        parent::__construct($element);
    }

}
