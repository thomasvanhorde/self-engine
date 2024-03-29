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
 * @version    $Id: Query.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * zend_Gdata_Query
 */
require_once('zend/Gdata/Query.php');

/**
 * zend_Gdata_Gapps
 */
require_once('zend/Gdata/Gapps.php');

/**
 * Assists in constructing queries for Google Apps entries. This class
 * provides common methods used by all other Google Apps query classes.
 *
 * This class should never be instantiated directly. Instead, instantiate a
 * class which inherits from this class.
  *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Gapps
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class zend_Gdata_Gapps_Query extends zend_Gdata_Query
{

    /**
     * The domain which is being administered via the Provisioning API.
     *
     * @var string
     */
    protected $_domain = null;

    /**
     * Create a new instance.
     *
     * @param string $domain (optional) The Google Apps-hosted domain to use
     *          when constructing query URIs.
     */
    public function __construct($domain = null)
    {
        parent::__construct();
        $this->_domain = $domain;
    }

    /**
     * Set domain for this service instance. This should be a fully qualified
     * domain, such as 'foo.example.com'.
     *
     * This value is used when calculating URLs for retrieving and posting
     * entries. If no value is specified, a URL will have to be manually
     * constructed prior to using any methods which interact with the Google
     * Apps provisioning service.
     *
     * @param string $value The domain to be used for this session.
     */
    public function setDomain($value)
    {
        $this->_domain = $value;
    }

    /**
     * Get domain for this service instance. This should be a fully qualified
     * domain, such as 'foo.example.com'. If no domain is set, null will be
     * returned.
     *
     * @see setDomain
     * @return string The domain to be used for this session, or null if not
     *          set.
     */
    public function getDomain()
    {
        return $this->_domain;
    }

    /**
     * Returns the base URL used to access the Google Apps service, based
     * on the current domain. The current domain can be temporarily
     * overridden by providing a fully qualified domain as $domain.
     *
     * @see setDomain
     * @param string $domain (optional) A fully-qualified domain to use
     *          instead of the default domain for this service instance.
     */
     public function getBaseUrl($domain = null)
     {
         if ($domain !== null) {
             return zend_Gdata_Gapps::APPS_BASE_FEED_URI . '/' . $domain;
         }
         else if ($this->_domain !== null) {
             return zend_Gdata_Gapps::APPS_BASE_FEED_URI . '/' . $this->_domain;
         }
         else {
             require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
             throw new zend_Gdata_App_InvalidArgumentException(
                 'Domain must be specified.');
         }
     }

}
