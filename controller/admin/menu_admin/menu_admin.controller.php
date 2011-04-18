<?php
	/**
	 *	Contrôleur du menu
	 *
	 *	@author Thomas Van Horde
	 *	@version 1.0
	 */
	class menu_admin_controller {

		// Attributs de la classe
		private $_view;

		/**
		 *	Constructeur :
		 		- Récupération de la bonne instance de Smarty
		 		- Déclaration du dossier contenant les vues de ce contrôleur
		 *
		 *	@author Thomas Van Horde
		 *	@version 1.1
		 *	@see: CLASS_COMPONENT
		 *	@see: CLASS_USER
		 */
        function __construct() {
            $this->_view = Base::Load(CLASS_COMPONENT)->_view;
        }

		/**
		 *	Envoi des données au gabarit
		 *
		 *	@author Thomas Van Horde
		 *	@version 1.0
		 */
        function defaut(){
            $complete_url = implode('/',$_GET['url']);
            $this->_view->assign('myCompletURL', $complete_url);
            $this->_view->assign('myURL', $_GET['url']);
            $this->_view->addBlock('admin_mainNav', 'admin_mainNav.tpl', 'view/admin/');
        }
    }

/*
	Fin du fichier : menu_admin.controller.php
	Chemin du fichier : /engine/controller/admin/menu_admin/
*/