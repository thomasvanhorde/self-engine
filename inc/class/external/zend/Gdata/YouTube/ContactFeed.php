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
 * @version    $Id: ContactFeed.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Media_Feed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Media/Feed.php';

/**
 * @see zend_Gdata_YouTube_ContactEntry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/YouTube/ContactEntry.php';

/**
 * The YouTube contacts flavor of an Atom Feed with media support
 * Represents a list of individual contacts, where each contained entry is
 * a contact.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage YouTube
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_YouTube_ContactFeed extends zend_Gdata_Media_Feed
{

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'zend_Gdata_YouTube_ContactEntry';

    /**
     * Constructs a new YouTube Contact Feed object, to represent
     * a feed of contacts for a user
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
