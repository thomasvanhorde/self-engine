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
 * @subpackage Books
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: InfoLink.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Books_Extension_BooksLink
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Books/Extension/BooksLink.php';

/**
 * Describes an info link
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Books
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Books_Extension_InfoLink extends
    zend_Gdata_Books_Extension_BooksLink
{

    /**
     * Constructor for zend_Gdata_Books_Extension_InfoLink which
     * Describes an info link
     *
     * @param string|null $href Linked resource URI
     * @param string|null $rel Forward relationship
     * @param string|null $type Resource MIME type
     * @param string|null $hrefLang Resource language
     * @param string|null $title Human-readable resource title
     * @param string|null $length Resource length in octets
     */
    public function __construct($href = null, $rel = null, $type = null,
            $hrefLang = null, $title = null, $length = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Books::$namespaces);
        parent::__construct($href, $rel, $type, $hrefLang, $title, $length);
    }

}
