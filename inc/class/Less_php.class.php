<?php

$loadParent = function ($file) {
    if (file_exists(FOLDER_CLASS_EXT.$file)) {
        require_once FOLDER_CLASS_EXT.$file;
    } elseif (file_exists(ENGINE_URL.FOLDER_CLASS_EXT.$file)) {
        require_once ENGINE_URL.FOLDER_CLASS_EXT.$file;
    } else {
       throw new Exception(sprintf('Unable to find %s.', $file));
    }
};
$loadParent('less-php-0-2/lessc.inc.php');

/**
 * Compiles less files.
 *
 * @author  Thomas Van Horde
 * @author  Fabien Nouaillat
 * @package self-engine
 */
class Less_php extends lessc
{
    public function Load($file_less, $file_css)
    {
        try {
            $this->ccompile($file_less, $file_css);
        } catch (Exception $e) {
            exit('<strong>Less compilation error:</strong> '.$e->getMessage());
        }
    }
}