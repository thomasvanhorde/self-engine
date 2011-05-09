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
 * @version    $Id: Element.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_App_Extension
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/Extension.php';

/**
 * Class that represents elements which were not handled by other parsing
 * code in the library.
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage App
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_App_Extension_Element extends zend_Gdata_App_Extension
{

    public function __construct($rootElement=null, $rootNamespace=null, $rootNamespaceURI=null, $text=null){
        parent::__construct();
        $this->_rootElement = $rootElement;
        $this->_rootNamespace = $rootNamespace;
        $this->_rootNamespaceURI = $rootNamespaceURI;
        $this->_text = $text;
    }

    public function transferFromDOM($node)
    {
        parent::transferFromDOM($node);
        $this->_rootNamespace = null;
        $this->_rootNamespaceURI = $node->namespaceURI;
        $this->_rootElement = $node->localName;
    }

}
