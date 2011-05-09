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
 * @subpackage Gapps
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id:$
 */

/**
 * @see zend_Gdata_Feed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Feed.php';

/**
 * @see zend_Gdata_Gapps_GroupEntry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Gapps/GroupEntry.php';

/**
 * Data model for a collection of Google Apps group entries, usually
 * provided by the Google Apps servers.
 *
 * For information on requesting this feed from a server, see the Google
 * Apps service class, zend_Gdata_Gapps.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Gapps
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Gapps_GroupFeed extends zend_Gdata_Feed
{

    protected $_entryClassName = 'zend_Gdata_Gapps_GroupEntry';
    protected $_feedClassName = 'zend_Gdata_Gapps_GroupFeed';

}