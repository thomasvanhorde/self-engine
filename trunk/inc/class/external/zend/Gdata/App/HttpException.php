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
 * @version    $Id: HttpException.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * zend_Gdata_App_Exception
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/Exception.php';

/**
 * zend_Http_Client_Exception
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Http/Client/Exception.php';

/**
 * Gdata exceptions
 *
 * Class to represent exceptions that occur during Gdata operations.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage App
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_App_HttpException extends zend_Gdata_App_Exception
{

    protected $_httpClientException = null;
    protected $_response = null;

    /**
     * Create a new zend_Gdata_App_HttpException
     *
     * @param  string $message Optionally set a message
     * @param zend_Http_Client_Exception Optionally pass in a zend_Http_Client_Exception
     * @param zend_Http_Response Optionally pass in a zend_Http_Response
     */
    public function __construct($message = null, $e = null, $response = null)
    {
        $this->_httpClientException = $e;
        $this->_response = $response;
        parent::__construct($message);
    }

    /**
     * Get the zend_Http_Client_Exception.
     *
     * @return zend_Http_Client_Exception
     */
    public function getHttpClientException()
    {
        return $this->_httpClientException;
    }

    /**
     * Set the zend_Http_Client_Exception.
     *
     * @param zend_Http_Client_Exception $value
     */
    public function setHttpClientException($value)
    {
        $this->_httpClientException = $value;
        return $this;
    }

    /**
     * Set the zend_Http_Response.
     *
     * @param zend_Http_Response $response
     */
    public function setResponse($response)
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * Get the zend_Http_Response.
     *
     * @return zend_Http_Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Get the body of the zend_Http_Response
     *
     * @return string
     */
    public function getRawResponseBody()
    {
        if ($this->getResponse()) {
            $response = $this->getResponse();
            return $response->getRawBody();
        }
        return null;
    }

}
