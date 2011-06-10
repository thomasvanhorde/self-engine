<?php

/**
 * Contrôleur de l'administration
 */

class admin_controller extends Component
{
    public  function defaut()
    {
        $this->_view->addBlock('content', 'defaut.tpl');
    }

    public function phpinfo()
    {
        exit(phpinfo());
    }
}


/* -- Fin du fichier -- */