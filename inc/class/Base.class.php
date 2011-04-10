<?php

/**
 *  @author Thomas VAN HORDE
 *  @description Singleton & MVC
 */

define('CLASS_LOADER_FILE','ClassLoader.php');

if(file_exists(FOLDER_CLASS_EXT.CLASS_LOADER_FILE))
	include FOLDER_CLASS_EXT.CLASS_LOADER_FILE;
elseif(file_exists(ENGINE_URL.FOLDER_CLASS_EXT.CLASS_LOADER_FILE))
	include ENGINE_URL.FOLDER_CLASS_EXT.CLASS_LOADER_FILE;
else
    Base::Load(CLASS_CORE_MESSAGE)->Critic('ERR_LOAD_CLASS_LOADER'); 

Class Base {

	protected $_view;
	protected $_bdd;
	protected $_buffer;

    /**
     * @return void
     * @description initialise la vue
     */
	function __construct(){
        $this->_view = Base::Load(CLASS_VUE);
	}

    /***
     * @static
     * @param  $url
     * @return void
     */
    private static function storeUrl($url){
        $_SESSION['location'][] = $url;
    }

    /***
     * @static
     * @param  $number
     * @return url
     */
    public static function getUrl($number){
        return $_SESSION['location'][count($_SESSION['location']) - $number];
    }

    /**
     * @param  $ClassName
     * @param bool $param
     * @param bool $singleton
     * @return object 
     */
	public static function Load($ClassName, $param = false, $singleton = true){
		static $instance;

		if (isset($instance[$ClassName]) && $singleton && !$param){
			$objet = $instance[$ClassName];
			if(DEBUG)	Debug::log('Class '.$ClassName. ' loaded in singleton mode');
		}
		else {
			if(defined($ClassName))	// A partir d'un nom de constante ?
				$ClassName = constant(ClassName);

			$objet = new $ClassName;	// new instance from __autoload - Php 5 Only !

			if($param && is_array($param))	// Insertion des parametres
				call_user_func_array(array($objet, $ClassName), $param);
			
			$instance[$ClassName] = &$objet;	// Référence à l'objet pour le Singleton
			if(DEBUG)	Debug::log('Class '.$ClassName. ' loaded in normal mode');
			if(DEBUG)	Debug::logMemory($instance[$ClassName], 'Instance of '.$ClassName);
			
		}
		return $objet;
	}

    /**
     * @return void
     * @description assign all constant to view
     */
	private function ConstantAssign(){
		foreach(get_defined_constants() as $consName => $constValue){
			$this->_view->assign($consName, $constValue);
		}
	}

    private function baseURL(){
        $baseUrl = HTTP_HOST.'/'.SYS_FOLDER.'/';
        $baseUrl = str_replace('///','/',$baseUrl);
        $baseUrl = str_replace('//','/',$baseUrl);
        define('BASE_URL', 'http://'.$baseUrl);
    }
	
	/**
     * @param  $Folder
     * @return void
     * @description Init MVC from arborescence.xml
     * @description Call listeners
     */
	public function Start($Folder){
		if(DEBUG)	Debug::logSpeed();
		if(DEBUG)   Debug::log(Base::Load(CLASS_CORE_MESSAGE)->Generic('MESS_BASE_START'));

        // Create Base URL
        $this->baseURL();

        // Store URL
        $this->storeUrl($Folder);
		
		// Assigne les constantes de config à View
		$this->ConstantAssign();

        // Parse URL & Load Xml infos
        $Ctr = $this->LoadDataPath($Folder);
        $Controller = $Ctr['controller'];

        // Assign Constant to var (necessary for object argument call)
        $INFOS_CONTROLLER = INFOS_CONTROLLER;
        $INFOS_METHOD = INFOS_METHOD;
        $INFOS_TITLE = INFOS_TITLE;
        $INFOS_BLOCKS = INFOS_BLOCKS;
        $INFOS_LAYOUT = INFOS_LAYOUT;
        $INFOS_ACCES_CONTROL = INFOS_ACCESS_CONTROL;

        // Assign values
        $ControllerName = explode('/', $Controller->$INFOS_CONTROLLER);
        $ControllerMethod = $Controller->$INFOS_METHOD;
        $ControllerTitle = $Controller->$INFOS_TITLE;
        $ControllerBlocks = $Controller->$INFOS_BLOCKS;
        $ControllerLayout = $Controller->$INFOS_LAYOUT;
        $ControllerAccessControl = $Controller->$INFOS_ACCES_CONTROL;




		// Class Component
		$ComponentObj = Base::Load(CLASS_COMPONENT);
		// View implemente
		$ComponentObj->_view = &$this->_view;
		// Views controller path
		$ComponentObj->_view->_folder = FOLDER_APPLICATION.implode('/',$ControllerName).'/'.FOLDER_VIEW;

        
        // Access Control
        if(!empty($ControllerAccessControl)){

            if(isset($ControllerAccessControl->login) && isset($ControllerAccessControl->password)) {
                $url_access = selEncode($Folder,'base64');
                if(!isset($_SESSION[SESSION_ACCESS_CONTROL][$ControllerName[count($ControllerName)-1]]) || !$_SESSION[SESSION_ACCESS_CONTROL][$ControllerName[count($ControllerName)-1]]){    // Access denied ?
                    echo '<META HTTP-EQUIV="Refresh" CONTENT="3; URL='.SYS_FOLDER.'ac_login/">';
                    $_SESSION[SESSION_REDIRECT] = $url_access;
                    Base::Load(CLASS_CORE_MESSAGE)->Critic('MESS_ERR_ACCESS_CONTROL');
                }
            }

            if(isset($ControllerAccessControl->$INFOS_CONTROLLER) && isset($ControllerAccessControl->$INFOS_METHOD)) {
                Base::Load(CLASS_CONTROLLER,array($ControllerAccessControl->$INFOS_CONTROLLER,$ControllerAccessControl->$INFOS_METHOD));
            }


        }
        
		// virtual $param to $_GET
        $_GET['param'] = $Ctr['param'];
        $_GET['url'] = $Ctr['url'];

		// Include controller
		if(file_exists(FOLDER_APPLICATION.implode('/',$ControllerName).'/'.$ControllerName[count($ControllerName)-1].CONTROLLER_EXT))
			include_once FOLDER_APPLICATION.implode('/',$ControllerName).'/'.$ControllerName[count($ControllerName)-1].CONTROLLER_EXT;
		elseif(file_exists(ENGINE_URL.FOLDER_APPLICATION.implode('/',$ControllerName).'/'.$ControllerName[count($ControllerName)-1].CONTROLLER_EXT))
			include_once ENGINE_URL.FOLDER_APPLICATION.implode('/',$ControllerName).'/'.$ControllerName[count($ControllerName)-1].CONTROLLER_EXT;



        // Listener $_POST
        if(isset($_POST[LISTENER_POST_TODO]))
            $this->ListenerPost($ControllerName[count($ControllerName)-1]);

		// Blocks externe
		if(isset($ControllerBlocks) && $ControllerBlocks->length != NULL){
			foreach($ControllerBlocks->children()  as $blk){
                if(DEBUG) Debug::log(Base::Load(CLASS_CORE_MESSAGE)->Generic('MESS_BLOCK').' '.$blk->controller.'::'.$blk->method);
				Base::Load(CLASS_CONTROLLER ,array($blk->controller, $blk->method));
            }
		}
        
		if(isset($ControllerMethod))
			Base::Load(CLASS_CONTROLLER,array($ControllerName[count($ControllerName)-1],$ControllerMethod));
		else
			Base::Load(CLASS_CONTROLLER,array($ControllerName[count($ControllerName)-1], false));


		// Assignation du Title de la page
		$this->_view->assign(INFOS_TITLE,$ControllerTitle);
  	
		// Assignation du layout
        $this->buffer(FOLDER_LAYOUT.$ControllerLayout);
		
		if(DEBUG)	Debug::log(Base::Load(CLASS_CORE_MESSAGE)->Generic('MESS_BASE_END'));
		if(DEBUG)	Debug::logSpeed();
	}

    /**
     * @param  $ControllerName
     * @return void
     */
    private function ListenerPost($ControllerName){
        if(isset($_POST[LISTENER_POST_TODO])){
            $t = explode('[',$_POST[LISTENER_POST_TODO]);
            if(isset($t[1])){
                $u = explode(']',$t[1]);
                $contr = $t[0];
                $method = $u[0];
            }
            else {
                $contr = $ControllerName;
                $method = $_POST[LISTENER_POST_TODO];
            }

            // Liberation de mémoire
            unset($_POST[LISTENER_POST_TODO]);

            Base::Load(CLASS_CONTROLLER,array($contr,CONTROLLER_POST_PREC.$method.'#(#'.serialize($_POST).'#)#'));
        }
    }

    /**
     * @param  $Folder
     * @return 
     */
    public static function LoadDataPath($Folder){

        if(SYS_FOLDER != '/'){
            $a = explode(SYS_FOLDER, $Folder);
            $folders = explode('/', $a[1]);
        }
        else
            $folders = explode('/', $Folder);

        $f = '';
        $param = $url = array();


        /*
         * Load Xml Arbo
         */

        // Xml from www/ folder
        $XmlFileWeb = INFOS_XML;
        $XmlDomWeb = simplexml_load_file($XmlFileWeb);

        // Xml from engine/ folder
        $XmlFileEngine = ENGINE_URL.INFOS_XML;
        $XmlDomEngine = simplexml_load_file($XmlFileEngine);

        // Merge in unique object
        $XmlDom = (object) array_merge((array) $XmlDomWeb, (array) $XmlDomEngine);

        // Need double var for after
        $Controller = $XmlDom;

        // Test url with arbo
        foreach($folders as $f){
            if(isset($Controller->$f)){ // Identifiate in Xml
                $Controller = $Controller->$f;
                $url[] = $f;
            }
            elseif(!empty($f)) {  // No indentifiate ? = virtual $_GET param
                $param[] = $f;
            }
        }

        if($Controller === $XmlDom){    // Si Homepage
            $defaut = INFOS_INDEX;
            $Controller = $Controller->$defaut; // Controlleur pas défaut
        }

        return array('controller' => $Controller, 'param' => $param, 'url' => $url);

    }

    /**
     * @param  $layout
     * @return void
     * @description Save buffer
     */
    private function buffer($layout){
        ob_start();
        ob_implicit_flush(0);

		$this->_view->display($layout);
		$this->_buffer = $this->encode(ob_get_contents());
		ob_end_clean();
    }

    /**
     * @param  $html
     * @param string $encode
     * @return string
     */
    public static function encode($html){
        if(FORCE_ENCODE_UTF8)
            $html = utf8_encode($html);

        return $html;
    }


    /**
     * @return void
     * @description display buffer
     */
    public function Display(){
        if(GZIP_COMPRESS)
            echo compress_output_option($this->_buffer);
        else
            echo $this->_buffer;
    }


}






function compress_output_option($output)
{
    // Compress the data into a new var.
    $compressed_out = gzencode($output);

    // Don't compress any pages less than 1000 bytes
    // as it's not worth the overhead at either side.
    if(strlen($output) >= 1000)
    {
        error_log('compression.php Gzipd Output'."\n"
                 .'Before compression size '
                 .strlen($output).' bytes'."\n"
                 .' After compression size '
                 .strlen($compressed_out).' bytes');
        // Tell the browser the content is compressed with gzip
        header("Content-Encoding: gzip");
        return $compressed_out;
    }
    else
    {
        // No compression
        error_log('compression.php Standard Output.');
        return $output;
    }
}


?>