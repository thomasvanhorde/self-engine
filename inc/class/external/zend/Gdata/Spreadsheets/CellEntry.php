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
 * @category     zend
 * @package      zend_Gdata
 * @subpackage   Spreadsheets
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: CellEntry.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Entry
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Entry.php';

/**
 * @see zend_Gdata_Spreadsheets_Extension_Cell
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Spreadsheets/Extension/Cell.php';

/**
 * Concrete class for working with Cell entries.
 *
 * @category     zend
 * @package      zend_Gdata
 * @subpackage   Spreadsheets
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Spreadsheets_CellEntry extends zend_Gdata_Entry
{

    protected $_entryClassName = 'zend_Gdata_Spreadsheets_CellEntry';
    protected $_cell;

    /**
     * Constructs a new zend_Gdata_Spreadsheets_CellEntry object.
     * @param string $uri (optional)
     * @param DOMElement $element (optional) The DOMElement on which to base this object.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Spreadsheets::$namespaces);
        parent::__construct($element);
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->_cell != null) {
            $element->appendChild($this->_cell->getDOM($element->ownerDocument));
        }
        return $element;
    }

    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
        case $this->lookupNamespace('gs') . ':' . 'cell';
            $cell = new zend_Gdata_Spreadsheets_Extension_Cell();
            $cell->transferFromDOM($child);
            $this->_cell = $cell;
            break;
        default:
            parent::takeChildFromDOM($child);
            break;
        }
    }

    /**
     * Gets the Cell element of this Cell Entry.
     * @return zend_Gdata_Spreadsheets_Extension_Cell
     */
    public function getCell()
    {
        return $this->_cell;
    }

    /**
     * Sets the Cell element of this Cell Entry.
     * @param zend_Gdata_Spreadsheets_Extension_Cell $cell
		 * @return zend_Gdata_Spreadsheets_CellEntry
     */
    public function setCell($cell)
    {
        $this->_cell = $cell;
        return $this;
    }

}
