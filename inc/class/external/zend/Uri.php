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
 * @category  zend
 * @package   zend_Uri
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd     New BSD License
 * @version   $Id: Uri.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * Abstract class for all zend_Uri handlers
 *
 * @category  zend
 * @package   zend_Uri
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd     New BSD License
 */
abstract class zend_Uri
{
    /**
     * Scheme of this URI (http, ftp, etc.)
     *
     * @var string
     */
    protected $_scheme = '';

    /**
     * Global configuration array
     *
     * @var array
     */
    static protected $_config = array(
        'allow_unwise' => false
    );

    /**
     * Return a string representation of this URI.
     *
     * @see    getUri()
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->getUri();
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
            return '';
        }
    }

    /**
     * Convenience function, checks that a $uri string is well-formed
     * by validating it but not returning an object.  Returns TRUE if
     * $uri is a well-formed URI, or FALSE otherwise.
     *
     * @param  string $uri The URI to check
     * @return boolean
     */
    public static function check($uri)
    {
        try {
            $uri = self::factory($uri);
        } catch (Exception $e) {
            return false;
        }

        return $uri->valid();
    }

    /**
     * Create a new zend_Uri object for a URI.  If building a new URI, then $uri should contain
     * only the scheme (http, ftp, etc).  Otherwise, supply $uri with the complete URI.
     *
     * @param  string $uri       The URI form which a zend_Uri instance is created
     * @param  string $className The name of the class to use in order to manipulate URI
     * @throws zend_Uri_Exception When an empty string was supplied for the scheme
     * @throws zend_Uri_Exception When an illegal scheme is supplied
     * @throws zend_Uri_Exception When the scheme is not supported
     * @throws zend_Uri_Exception When $className doesn't exist or doesn't implements zend_Uri
     * @return zend_Uri
     * @link   http://www.faqs.org/rfcs/rfc2396.html
     */
    public static function factory($uri = 'http', $className = null)
    {
        // Separate the scheme from the scheme-specific parts
        $uri            = explode(':', $uri, 2);
        $scheme         = strtolower($uri[0]);
        $schemeSpecific = isset($uri[1]) === true ? $uri[1] : '';

        if (strlen($scheme) === 0) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Uri/Exception.php';
            throw new zend_Uri_Exception('An empty string was supplied for the scheme');
        }

        // Security check: $scheme is used to load a class file, so only alphanumerics are allowed.
        if (ctype_alnum($scheme) === false) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Uri/Exception.php';
            throw new zend_Uri_Exception('Illegal scheme supplied, only alphanumeric characters are permitted');
        }

        if ($className === null) {
            /**
             * Create a new zend_Uri object for the $uri. If a subclass of zend_Uri exists for the
             * scheme, return an instance of that class. Otherwise, a zend_Uri_Exception is thrown.
             */
            switch ($scheme) {
                case 'http':
                    // Break intentionally omitted
                case 'https':
                    $className = 'zend_Uri_Http';
                    break;

                case 'mailto':
                    // TODO
                default:
                    require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Uri/Exception.php';
                    throw new zend_Uri_Exception("Scheme \"$scheme\" is not supported");
                    break;
            }
        }

        require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Loader.php';
        try {
            zend_Loader::loadClass($className);
        } catch (Exception $e) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Uri/Exception.php';
            throw new zend_Uri_Exception("\"$className\" not found");
        }

        $schemeHandler = new $className($scheme, $schemeSpecific);

        if (! $schemeHandler instanceof zend_Uri) {
            require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Uri/Exception.php';
            throw new zend_Uri_Exception("\"$className\" is not an instance of zend_Uri");
        }

        return $schemeHandler;
    }

    /**
     * Get the URI's scheme
     *
     * @return string|false Scheme or false if no scheme is set.
     */
    public function getScheme()
    {
        if (empty($this->_scheme) === false) {
            return $this->_scheme;
        } else {
            return false;
        }
    }

    /**
     * Set global configuration options
     *
     * @param zend_Config|array $config
     */
    static public function setConfig($config)
    {
        if ($config instanceof zend_Config) {
            $config = $config->toArray();
        } elseif (!is_array($config)) {
            throw new zend_Uri_Exception("Config must be an array or an instance of zend_Config.");
        }

        foreach ($config as $k => $v) {
            self::$_config[$k] = $v;
        }
    }

    /**
     * zend_Uri and its subclasses cannot be instantiated directly.
     * Use zend_Uri::factory() to return a new zend_Uri object.
     *
     * @param string $scheme         The scheme of the URI
     * @param string $schemeSpecific The scheme-specific part of the URI
     */
    abstract protected function __construct($scheme, $schemeSpecific = '');

    /**
     * Return a string representation of this URI.
     *
     * @return string
     */
    abstract public function getUri();

    /**
     * Returns TRUE if this URI is valid, or FALSE otherwise.
     *
     * @return boolean
     */
    abstract public function valid();
}
