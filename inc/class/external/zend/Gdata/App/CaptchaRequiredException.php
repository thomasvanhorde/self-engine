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
 * @version    $Id: CaptchaRequiredException.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_App_CaptchaRequiredException
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/AuthException.php';

/**
 * Gdata exceptions
 *
 * Class to represent an exception that occurs during the use of ClientLogin.
 * This particular exception happens when a CAPTCHA challenge is issued. This
 * challenge is a visual puzzle presented to the user to prove that they are
 * not an automated system.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage App
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_App_CaptchaRequiredException extends zend_Gdata_App_AuthException
{
    /**
     * The Google Accounts URL prefix.
     */
    const ACCOUNTS_URL = 'https://www.google.com/accounts/';

    /**
     * The token identifier from the server.
     *
     * @var string
     */
    private $captchaToken;

    /**
     * The URL of the CAPTCHA image.
     *
     * @var string
     */
    private $captchaUrl;

    /**
     * Constructs the exception to handle a CAPTCHA required response.
     *
     * @param string $captchaToken The CAPTCHA token ID provided by the server.
     * @param string $captchaUrl The URL to the CAPTCHA challenge image.
     */
    public function __construct($captchaToken, $captchaUrl) {
        $this->captchaToken = $captchaToken;
        $this->captchaUrl = zend_Gdata_App_CaptchaRequiredException::ACCOUNTS_URL . $captchaUrl;
        parent::__construct('CAPTCHA challenge issued by server');
    }

    /**
     * Retrieves the token identifier as provided by the server.
     *
     * @return string
     */
    public function getCaptchaToken() {
        return $this->captchaToken;
    }

    /**
     * Retrieves the URL CAPTCHA image as provided by the server.
     *
     * @return string
     */
    public function getCaptchaUrl() {
        return $this->captchaUrl;
    }

}
