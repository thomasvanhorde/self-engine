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
 * @subpackage YouTube
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Private.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Extension
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Extension.php';

/**
 * Represents the yt:private element used by the YouTube data API
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage YouTube
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_YouTube_Extension_Private extends zend_Gdata_Extension
{

    protected $_rootNamespace = 'yt';
    protected $_rootElement = 'private';

    /**
     * Constructs a new zend_Gdata_YouTube_Extension_Private object.
     */
    public function __construct()
    {
        $this->registerAllNamespaces(zend_Gdata_YouTube::$namespaces);
        parent::__construct();
    }

    /**
     * Retrieves a DOMElement which corresponds to this element and all
     * child properties.  This is used to build an entry back into a DOM
     * and eventually XML text for sending to the server upon updates, or
     * for application storage/persistence.
     *
     * @param DOMDocument $doc The DOMDocument used to construct DOMElements
     * @return DOMElement The DOMElement representing this element and all
     * child properties.
     */
    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        return $element;
    }

    /**
     * Given a DOMNode representing an attribute, tries to map the data into
     * instance members.  If no mapping is defined, the name and valueare
     * stored in an array.
     *
     * @param DOMNode $attribute The DOMNode attribute needed to be handled
     */
    protected function takeAttributeFromDOM($attribute)
    {
        parent::takeAttributeFromDOM($attribute);
    }

}
