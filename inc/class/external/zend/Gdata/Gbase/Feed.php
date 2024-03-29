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
 * @subpackage Gbase
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Feed.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Feed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Feed.php';

/**
 * Base class for the Google Base Feed
 *
 * @link http://code.google.com/apis/base/
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Gbase
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Gbase_Feed extends zend_Gdata_Feed
{
    /**
     * The classname for the feed.
     *
     * @var string
     */
    protected $_feedClassName = 'zend_Gdata_Gbase_Feed';

    /**
     * Create a new instance.
     *
     * @param DOMElement $element (optional) DOMElement from which this
     *          object should be constructed.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Gbase::$namespaces);
        parent::__construct($element);
    }
}
