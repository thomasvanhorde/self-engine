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
 * @package    zend_Http
 * @subpackage Client_Adapter
 * @version    $Id: Test.php 23775 2011-03-01 17:25:24Z ralph $
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * @see zend_Uri_Http
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Uri/Http.php';
/**
 * @see zend_Http_Response
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Http/Response.php';
/**
 * @see zend_Http_Client_Adapter_Interface
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Http/Client/Adapter/Interface.php';

/**
 * A testing-purposes adapter.
 *
 * Should be used to test all components that rely on zend_Http_Client,
 * without actually performing an HTTP request. You should instantiate this
 * object manually, and then set it as the client's adapter. Then, you can
 * set the expected response using the setResponse() method.
 *
 * @category   zend
 * @package    zend_Http
 * @subpackage Client_Adapter
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Http_Client_Adapter_Test implements zend_Http_Client_Adapter_Interface
{
    /**
     * Parameters array
     *
     * @var array
     */
    protected $config = array();

    /**
     * Buffer of responses to be returned by the read() method.  Can be
     * set using setResponse() and addResponse().
     *
     * @var array
     */
    protected $responses = array("HTTP/1.1 400 Bad Request\r\n\r\n");

    /**
     * Current position in the response buffer
     *
     * @var integer
     */
    protected $responseIndex = 0;

    /**
     * Wether or not the next request will fail with an exception
     *
     * @var boolean
     */
    protected $_nextRequestWillFail = false;

    /**
     * Adapter constructor, currently empty. Config is set using setConfig()
     *
     */
    public function __construct()
    { }

    /**
     * Set the nextRequestWillFail flag
     *
     * @param boolean $flag
     * @return zend_Http_Client_Adapter_Test
     */
    public function setNextRequestWillFail($flag)
    {
        $this->_nextRequestWillFail = (bool) $flag;

        return $this;
    }

    /**
     * Set the configuration array for the adapter
     *
     * @param zend_Config | array $config
     */
    public function setConfig($config = array())
    {
        if ($config instanceof zend_Config) {
            $config = $config->toArray();

        } elseif (! is_array($config)) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Http/Client/Adapter/Exception.php';
            throw new zend_Http_Client_Adapter_Exception(
                'Array or zend_Config object expected, got ' . gettype($config)
            );
        }

        foreach ($config as $k => $v) {
            $this->config[strtolower($k)] = $v;
        }
    }


    /**
     * Connect to the remote server
     *
     * @param string  $host
     * @param int     $port
     * @param boolean $secure
     * @param int     $timeout
     * @throws zend_Http_Client_Adapter_Exception
     */
    public function connect($host, $port = 80, $secure = false)
    {
        if ($this->_nextRequestWillFail) {
            $this->_nextRequestWillFail = false;
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Http/Client/Adapter/Exception.php';
            throw new zend_Http_Client_Adapter_Exception('Request failed');
        }
    }

    /**
     * Send request to the remote server
     *
     * @param string        $method
     * @param zend_Uri_Http $uri
     * @param string        $http_ver
     * @param array         $headers
     * @param string        $body
     * @return string Request as string
     */
    public function write($method, $uri, $http_ver = '1.1', $headers = array(), $body = '')
    {
        $host = $uri->getHost();
            $host = (strtolower($uri->getScheme()) == 'https' ? 'sslv2://' . $host : $host);

        // Build request headers
        $path = $uri->getPath();
        if ($uri->getQuery()) $path .= '?' . $uri->getQuery();
        $request = "{$method} {$path} HTTP/{$http_ver}\r\n";
        foreach ($headers as $k => $v) {
            if (is_string($k)) $v = ucfirst($k) . ": $v";
            $request .= "$v\r\n";
        }

        // Add the request body
        $request .= "\r\n" . $body;

        // Do nothing - just return the request as string

        return $request;
    }

    /**
     * Return the response set in $this->setResponse()
     *
     * @return string
     */
    public function read()
    {
        if ($this->responseIndex >= count($this->responses)) {
            $this->responseIndex = 0;
        }
        return $this->responses[$this->responseIndex++];
    }

    /**
     * Close the connection (dummy)
     *
     */
    public function close()
    { }

    /**
     * Set the HTTP response(s) to be returned by this adapter
     *
     * @param zend_Http_Response|array|string $response
     */
    public function setResponse($response)
    {
        if ($response instanceof zend_Http_Response) {
            $response = $response->asString("\r\n");
        }

        $this->responses = (array)$response;
        $this->responseIndex = 0;
    }

    /**
     * Add another response to the response buffer.
     *
     * @param string zend_Http_Response|$response
     */
    public function addResponse($response)
    {
         if ($response instanceof zend_Http_Response) {
            $response = $response->asString("\r\n");
        }

        $this->responses[] = $response;
    }

    /**
     * Sets the position of the response buffer.  Selects which
     * response will be returned on the next call to read().
     *
     * @param integer $index
     */
    public function setResponseIndex($index)
    {
        if ($index < 0 || $index >= count($this->responses)) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Http/Client/Adapter/Exception.php';
            throw new zend_Http_Client_Adapter_Exception(
                'Index out of range of response buffer size');
        }
        $this->responseIndex = $index;
    }
}
