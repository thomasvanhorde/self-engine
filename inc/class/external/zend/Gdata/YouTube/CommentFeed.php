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
 * @version    $Id: CommentFeed.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_feed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Feed.php';

/**
 * @see zend_Gdata_YouTube_CommentEntry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/YouTube/CommentEntry.php';

/**
 * The YouTube comments flavor of an Atom Feed
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage YouTube
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_YouTube_CommentFeed extends zend_Gdata_Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'zend_Gdata_YouTube_CommentEntry';

    /**
     * Constructs a new YouTube Comment Feed object, to represent
     * a feed of comments for an individual video
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
