<?php

/* ------------------------------- CONSTANTS -------------------------------- */

// Folders
define('FOLDER_INC', 'inc/');
define('FOLDER_CLASS', FOLDER_INC.'class/');
define('FOLDER_CLASS_EXT', FOLDER_CLASS.'external/');
define('FOLDER_CLASS_EXTENSION', FOLDER_CLASS.'extension/');
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

// Template
define('TEMPLATE_EXT','');

// Controllers
define('CONTROLLER_EXT','.controller.php');
define('CONTROLLER_NAME_EXT','_controller');
define('CONTROLLER_POST_PREC','POST_');

// Extensions
define('EXTENSION_EXT','.ext.php');
define('EXTENSION_NAME_EXT','_extension');

// Classes
define('CLASS_EXTENSION', '.class.php');

// Sessions
define('SESSION_ACCESS_CONTROL', 'access_control');
define('SESSION_REDIRECT', 'redirect');
define('SESSION_CM_UPDATE', 'CM_update');

// Listeners
define('LISTENER_POST_TODO', 'todo');

// File info
define('INFOS_XML_CORE_MESSAGE','coremessage.xml');
define('INFOS_XML_CONTENT_TYPE','content_type.xml');
define('INFOS_XML_CONTENT_STRUCT','content_struct.xml');
define('INFOS_XML',FOLDER_INC.'arborescence.xml');
define('INFOS_JSON_MEDIA',FOLDER_INC.'media.json');
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

// Server
define('HTTP_HOST', $_SERVER['HTTP_HOST']);

if (isset($_SERVER['REDIRECT_URL'])) {
    define('HTTP_HOST_REQUEST', 'http://'.HTTP_HOST.$_SERVER['REDIRECT_URL']);
} else {
    define('HTTP_HOST_REQUEST', 'http://'.HTTP_HOST);
}

/* -----------------------------------------------------------------------------
  ~ Aenyhm's thoughts ~

  Too much of constants kills constants!
  Why not put them in a serialized format (XML/JSON/YAML)?
----------------------------------------------------------------------------- */


/* ---------------------------- ERROR REPORTING ----------------------------- */

// No effect if they are already defined
define_once('DEBUG_LEVEL', 0);
define_once('DEV', false);

if (DEV) {
    switch (DEBUG_LEVEL) {
        case 0:
            $show_errors = 0;
        break;
        case 1:
            $show_errors = E_ALL ^ E_NOTICE;
        break;
        case 2:
            $show_errors = E_ALL;
        break;
        case 3:
            $show_errors = -1;
        break;
        default:
            throw new InvalidArgumentException(
                'The constant DEBUG_LEVEL does not have a good value.'
            );
    }
} else {
    $show_errors = 0;
}

error_reporting($show_errors);