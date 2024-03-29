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
 * @version    $Id: ColCount.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Entry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Entry.php';

/**
 * @see zend_Gdata_Extension
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Extension.php';


/**
 * Concrete class for working with colCount elements.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Spreadsheets
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Spreadsheets_Extension_ColCount extends zend_Gdata_Extension
{

    protected $_rootElement = 'colCount';
    protected $_rootNamespace = 'gs';

    /**
     * Constructs a new zend_Gdata_Spreadsheets_Extension_ColCount element.
     * @param string $text (optional) Text contents of the element.
     */
    public function __construct($text = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Spreadsheets::$namespaces);
        parent::__construct();
        $this->_text = $text;
    }
}
