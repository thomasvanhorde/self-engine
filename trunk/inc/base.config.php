<?php

/*
 * Folder define
 */
define('FOLDER_INC', 'inc/');
define('FOLDER_CLASS', FOLDER_INC.'class/');
define('FOLDER_CLASS_EXT', FOLDER_CLASS.'ext/');
define('FOLDER_CLASS_BDD', FOLDER_CLASS.'bdd/');
define('FOLDER_CLASS_BDD_MODEL', FOLDER_CLASS_BDD.'modeles/');
define('FOLDER_CLASS_BDD_CLASS', FOLDER_CLASS_BDD.'class/');
define('FOLDER_WEB','web/');
define('FOLDER_APPLICATION','controller/');
define('FOLDER_LAYOUT','view/');
define('FOLDER_VIEW','view/');
define('FOLDER_CACHE','cache/');
define('FOLDER_THEME',SYS_FOLDER.'themes/');
define('FOLDER_MEDIA_IMAGE',SYS_FOLDER.'media/images/');
define('FOLDER_CONTENT_MANAGER','contentManager/');

/*
 * Template define
 */
define('TEMPLATE_EXT','');

/*
 * Controller define
 */
define('CONTROLLER_EXT','.controller.php');
define('CONTROLLER_NAME_EXT','_controller');
define('CONTROLLER_POST_PREC','POST_');

/*
 * Class define
 */
define('CLASS_EXTENSION', '.class.php');

/*
 * Session define
 */
define('SESSION_ACCESS_CONTROL', 'access_control');
define('SESSION_REDIRECT', 'redirect');

/*
 * Listeners define
 */
define('LISTENER_POST_TODO', 'todo');


/*
 * File info define
 */
define('INFOS_XML_CORE_MESSAGE','coremessage.xml');
define('INFOS_XML_CONTENT_TYPE','content_type.xml');
define('INFOS_XML_CONTENT_STRUCT','content_struct.xml');
define('INFOS_XML',FOLDER_INC.'arborescence.xml');
define('INFOS_INDEX','index');
define('INFOS_TITLE','title');
define('INFOS_CONTROLLER','controller');
define('INFOS_METHOD','method');
define('INFOS_METHOD_DEFAUT','defaut');
define('INFOS_LAYOUT','layout');
define('INFOS_BLOCKS','blocks');
define('INFOS_ACCESS_CONTROL','accessControl');
define('INFOS_ACCESS_CONTROL_LOGIN','login');
define('INFOS_ACCESS_CONTROL_PASSWORD','password');

/*
 * Others define
 */
define('HTTP_HOST',$_SERVER['HTTP_HOST']);
