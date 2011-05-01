<?php
	/**
	 *	Contrôleur du menu
	 *
	 *	@author Thomas Van Horde
	 *	@version 1.0
	 */
	class menu_admin_controller extends Component {

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

            if(isset($_SESSION[SESSION_ACCESS_CONTROL]))
                $this->_view->assign('myName', $_SESSION[SESSION_ACCESS_CONTROL]['login']);
            else {
                header('location: /'.$_GET['url'][0]);
                exit();
            }
            $this->_view->addBlock('admin_mainNav', 'admin_mainNav.tpl', 'view/admin/');

            $this->_view->addBlock('google_analytics', 'google_analytics.tpl', 'view/');
        }
    }

/*
	Fin du fichier : menu_admin.controller.php
	Chemin du fichier : /engine/controller/admin/menu_admin/
*/