<?php
/**
 * User: Thomas
 * Date: 22/03/11
 * Time: 18:25
 */

define('LESS_FILE','less-php-0-2/lessc.inc.php');

if(file_exists(FOLDER_CLASS_EXT.LESS_FILE))
	include FOLDER_CLASS_EXT.LESS_FILE;
elseif(file_exists(ENGINE_URL.FOLDER_CLASS_EXT.LESS_FILE))
	include ENGINE_URL.FOLDER_CLASS_EXT.LESS_FILE;
else
    Base::Load(CLASS_CORE_MESSAGE)->Critic('ERR_LOAD_CLASS_LESS');
 
class Less_php extends lessc{

    function Load($file_less, $file_css){
        try {
            $this->ccompile($file_less, $file_css);
        } catch (exception $ex) {
            exit('lessc fatal error:<br />'.$ex->getMessage());
        }
    }
}
