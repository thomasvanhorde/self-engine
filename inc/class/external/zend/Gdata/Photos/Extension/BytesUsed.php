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
 * @version    $Id: BytesUsed.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Extension
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Extension.php';

/**
 * @see zend_Gdata_Photos
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Photos.php';

/**
 * Represents the gphoto:bytesUsed element used by the API.
 * This indicates the number of bytes of storage used by an album.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Photos
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Photos_Extension_BytesUsed extends zend_Gdata_Extension
{

    protected $_rootNamespace = 'gphoto';
    protected $_rootElement = 'bytesUsed';

    /**
     * Constructs a new zend_Gdata_Photos_Extension_BytesUsed object.
     *
     * @param string $text (optional) The value to represent.
     */
    public function __construct($text = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Photos::$namespaces);
        parent::__construct();
        $this->setText($text);
    }

}
