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
 * @subpackage Spreadsheets
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: WorksheetFeed.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Feed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Feed.php';

/**
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Spreadsheets
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Spreadsheets_WorksheetFeed extends zend_Gdata_Feed
{

    /**
     * Constructs a new zend_Gdata_Spreadsheets_WorksheetFeed object.
     * @param DOMElement $element (optional) The DOMElement on whick to base this element.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Spreadsheets::$namespaces);
        parent::__construct($element);
    }

    /**
     * The classname for individual feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'zend_Gdata_Spreadsheets_WorksheetEntry';

    /**
     * The classname for the feed.
     *
     * @var string
     */
    protected $_feedClassName = 'zend_Gdata_Spreadsheets_WorksheetFeed';

}
