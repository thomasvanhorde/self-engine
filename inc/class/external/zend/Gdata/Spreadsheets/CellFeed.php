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
 * @subpackage Spreadsheets
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: CellFeed.php 23775 2011-03-01 17:25:24Z ralph $
 */

/**
 * @see zend_Gdata_Feed
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Feed.php';

/**
 * @see zend_Gdata_Spreadsheets_Extension_RowCount
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Spreadsheets/Extension/RowCount.php';

/**
 * @see zend_Gdata_Spreadsheets_Extension_ColCount
 */
require_once  ENGINE_URL.FOLDER_CLASS_EXT.'zend/Gdata/Spreadsheets/Extension/ColCount.php';

/**
 *
 * @category   zend
 * @package    zend_Gdata
 * @subpackage   Spreadsheets
 * @copyright  Copyright (c) 2005-2011 zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class zend_Gdata_Spreadsheets_CellFeed extends zend_Gdata_Feed
{

    /**
    * The classname for individual feed elements.
    *
    * @var string
    */
    protected $_entryClassName = 'zend_Gdata_Spreadsheets_CellEntry';

    /**
    * The classname for the feed.
    *
    * @var string
    */
    protected $_feedClassName = 'zend_Gdata_Spreadsheets_CellFeed';

    /**
    * The row count for the feed.
    *
    * @var zend_Gdata_Spreadsheets_Extension_RowCount
    */
    protected $_rowCount = null;

    /**
    * The column count for the feed.
    *
    * @var zend_Gdata_Spreadsheets_Extension_ColCount
    */
    protected $_colCount = null;

    /**
     * Constructs a new zend_Gdata_Spreadsheets_CellFeed object.
     * @param DOMElement $element (optional) The XML Element on which to base this object.
     */
    public function __construct($element = null)
    {
        $this->registerAllNamespaces(zend_Gdata_Spreadsheets::$namespaces);
        parent::__construct($element);
    }

    public function getDOM($doc = null, $majorVersion = 1, $minorVersion = null)
    {
        $element = parent::getDOM($doc, $majorVersion, $minorVersion);
        if ($this->rowCount != null) {
            $element->appendChild($this->_rowCount->getDOM($element->ownerDocument));
        }
        if ($this->colCount != null) {
            $element->appendChild($this->_colCount->getDOM($element->ownerDocument));
        }
        return $element;
    }

    protected function takeChildFromDOM($child)
    {
        $absoluteNodeName = $child->namespaceURI . ':' . $child->localName;
        switch ($absoluteNodeName) {
            case $this->lookupNamespace('gs') . ':' . 'rowCount';
                $rowCount = new zend_Gdata_Spreadsheets_Extension_RowCount();
                $rowCount->transferFromDOM($child);
                $this->_rowCount = $rowCount;
                break;
            case $this->lookupNamespace('gs') . ':' . 'colCount';
                $colCount = new zend_Gdata_Spreadsheets_Extension_ColCount();
                $colCount->transferFromDOM($child);
                $this->_colCount = $colCount;
                break;
            default:
                parent::takeChildFromDOM($child);
                break;
        }
    }

    /**
     * Gets the row count for this feed.
     * @return string The row count for the feed.
     */
    public function getRowCount()
    {
        return $this->_rowCount;
    }

    /**
     * Gets the column count for this feed.
     * @return string The column count for the feed.
     */
    public function getColumnCount()
    {
        return $this->_colCount;
    }

    /**
     * Sets the row count for this feed.
     * @param string $rowCount The new row count for the feed.
     */
    public function setRowCount($rowCount)
    {
        $this->_rowCount = $rowCount;
        return $this;
    }

    /**
     * Sets the column count for this feed.
     * @param string $colCount The new column count for the feed.
     */
    public function setColumnCount($colCount)
    {
        $this->_colCount = $colCount;
        return $this;
    }

}
