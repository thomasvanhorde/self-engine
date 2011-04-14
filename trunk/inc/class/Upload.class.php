<?php
/**
 * User: Thomas
 * Date: 13/04/11
 * Time: 20:48
 */

define('UPLOAD_CLASS','class.upload_0.31/class.upload.php');

if(file_exists(FOLDER_CLASS_EXT.UPLOAD_CLASS))
	include FOLDER_CLASS_EXT.UPLOAD_CLASS;
elseif(file_exists(ENGINE_URL.FOLDER_CLASS_EXT.UPLOAD_CLASS))
	include ENGINE_URL.FOLDER_CLASS_EXT.UPLOAD_CLASS;
else
    Base::Load(CLASS_CORE_MESSAGE)->Critic('ERR_LOAD_CLASS_UPLOAD');


class Upload extends upload_vero{

    function __construct(){}

    function send($file){
        parent::upload($file);
    }

}
