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
 * @subpackage App
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Summary.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_App_Extension_Text
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/Extension/Text.php';

/**
 * Represents the atom:summary element
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage App
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_App_Extension_Summary extends zend_Gdata_App_Extension_Text
{

    protected $_rootElement = 'summary';

}
