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
 * @subpackage DublinCore
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: DublinCore.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata.php';

/**
 * Service class for interacting with the services which use the
 * DublinCore extensions.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage DublinCore
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_DublinCore extends zend_Gdata
{

    /**
     * Namespaces used for zend_Gdata_DublinCore
     *
     * @var array
     */
    public static $namespaces = array(
        array('dc', 'http://purl.org/dc/terms', 1, 0)
    );

    /**
     * Create zend_Gdata_DublinCore object
     *
     * @param zend_Http_Client $client (optional) The HTTP client to use when
     *          when communicating with the Google servers.
     * @param string $applicationId The identity of the app in the form of Company-AppName-Version
     */
    public function __construct($client = null, $applicationId = 'MyCompany-MyApp-1.0')
    {
        $this->registerPackage('zend_Gdata_DublinCore');
        $this->registerPackage('zend_Gdata_DublinCore_Extension');
        parent::__construct($client, $applicationId);
    }

}
