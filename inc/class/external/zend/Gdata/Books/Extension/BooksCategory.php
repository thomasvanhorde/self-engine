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
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: BooksCategory.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_App_Extension_Category
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/Extension/Category.php';

/**
 * Describes a books category
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Books
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Books_Extension_BooksCategory extends
    zend_Gdata_App_Extension_Category
{

    /**
     * Constructor for zend_Gdata_Books_Extension_BooksCategory which
     * Describes a books category
     *
     * @param string|null $term An identifier representing the category within
     *        the categorization scheme.
     * @param string|null $scheme A string containing a URI identifying the
     *        categorization scheme.
     * @param string|null $label A human-readable label for display in
     *        end-user applications.
     */
    public function __construct($term = null, $scheme = null, $label = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Books::$namespaces);
        parent::__construct($term, $scheme, $label);
    }

}
