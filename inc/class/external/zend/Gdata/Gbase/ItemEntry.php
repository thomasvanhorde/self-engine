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
 * @subpackage Gbase
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: ItemEntry.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Gbase_Entry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Gbase/Entry.php';

/**
 * Concrete class for working with Item entries.
 *
 * @link http://code.google.com/apis/base/
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage Gbase
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Gbase_ItemEntry extends zend_Gdata_Gbase_Entry
{
    /**
     * The classname for individual item entry elements.
     *
     * @var string
     */
    protected $_entryClassName = 'zend_Gdata_Gbase_ItemEntry';

    /**
     * Set the value of the itme_type
     *
     * @param zend_Gdata_Gbase_Extension_ItemType $value The desired value for the item_type
     * @return zend_Gdata_Gbase_ItemEntry Provides a fluent interface
     */
    public function setItemType($value)
    {
        $this->addGbaseAttribute('item_type', $value, 'text');
        return $this;
    }

    /**
     * Adds a custom attribute to the entry in the following format:
     * &lt;g:[$name] type='[$type]'&gt;[$value]&lt;/g:[$name]&gt;
     *
     * @param string $name The name of the attribute
     * @param string $value The text value of the attribute
     * @param string $type (optional) The type of the attribute.
     *          e.g.: 'text', 'number', 'floatUnit'
     * @return zend_Gdata_Gbase_ItemEntry Provides a fluent interface
     */
    public function addGbaseAttribute($name, $text, $type = null) {
        $newBaseAttribute =  new zend_Gdata_Gbase_Extension_BaseAttribute($name, $text, $type);
        $this->_baseAttributes[] = $newBaseAttribute;
        return $this;
    }

    /**
     * Removes a Base attribute from the current list of Base attributes
     *
     * @param zend_Gdata_Gbase_Extension_BaseAttribute $baseAttribute The attribute to be removed
     * @return zend_Gdata_Gbase_ItemEntry Provides a fluent interface
     */
    public function removeGbaseAttribute($baseAttribute) {
        $baseAttributes = $this->_baseAttributes;
        for ($i = 0; $i < count($this->_baseAttributes); $i++) {
            if ($this->_baseAttributes[$i] == $baseAttribute) {
                array_splice($baseAttributes, $i, 1);
                break;
            }
        }
        $this->_baseAttributes = $baseAttributes;
        return $this;
    }

    /**
     * Uploads changes in this entry to the server using zend_Gdata_App
     *
     * @param boolean $dryRun Whether the transaction is dry run or not.
     * @param string|null $uri The URI to send requests to, or null if $data
     *        contains the URI.
     * @param string|null $className The name of the class that should we
     *        deserializing the server response. If null, then
     *        'zend_Gdata_App_Entry' will be used.
     * @param array $extraHeaders Extra headers to add to the request, as an
     *        array of string-based key/value pairs.
     * @return zend_Gdata_App_Entry The updated entry
     * @throws zend_Gdata_App_Exception
     */
    public function save($dryRun = false,
                         $uri = null,
                         $className = null,
                         $extraHeaders = array())
    {
        if ($dryRun == true) {
            $editLink = $this->getEditLink();
            if ($uri == null && $editLink !== null) {
                $uri = $editLink->getHref() . '?dry-run=true';
            }
            if ($uri === null) {
                require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
                throw new zend_Gdata_App_InvalidArgumentException('You must specify an URI which needs deleted.');
            }
            $service = new zend_Gdata_App($this->getHttpClient());
            return $service->updateEntry($this,
                                         $uri,
                                         $className,
                                         $extraHeaders);
        } else {
            parent::save($uri, $className, $extraHeaders);
        }
    }

    /**
     * Deletes this entry to the server using the referenced
     * zend_Http_Client to do a HTTP DELETE to the edit link stored in this
     * entry's link collection.
     *
     * @param boolean $dyrRun Whether the transaction is dry run or not
     * @return void
     * @throws zend_Gdata_App_Exception
     */
    public function delete($dryRun = false)
    {
        $uri = null;

        if ($dryRun == true) {
            $editLink = $this->getEditLink();
            if ($editLink !== null) {
                $uri = $editLink->getHref() . '?dry-run=true';
            }
            if ($uri === null) {
                require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/App/InvalidArgumentException.php';
                throw new zend_Gdata_App_InvalidArgumentException('You must specify an URI which needs deleted.');
            }
            parent::delete($uri);
        } else {
            parent::delete();
        }
    }

}
