<?php

/**
* Fichier de contrôlle d'accès
*
* @author: Thomas VAN HORDE <thomas.vanhorde@gmail.com>
* @version: 1
*/

class access_control_controller extends Component{

    public function defaut(){}
    /**
     * Test if login/mpd is correct and redirect
     * @param  $data array  data post
     * @return void
     */
    public function POST_connect($data){
        if(isset($data['user_name']) && isset($data['user_password'])){
            // To redirect 
            $redirect = selDecode($_SESSION['redirect'], 'base64');

            // Load redirect data
            $dataC = Base::LoadDataPath($redirect);
            $Controller = $dataC['controller'];
            $INFOS_ACCES_CONTROL = INFOS_ACCESS_CONTROL;
            $ControllerAccessControl = $Controller->$INFOS_ACCES_CONTROL;
            $ControllerAccessControlLogin = INFOS_ACCESS_CONTROL_LOGIN;
            $ControllerAccessControlPassword = INFOS_ACCESS_CONTROL_PASSWORD;
            $INFOS_CONTROLLER = INFOS_CONTROLLER;
            $ControllerName = $Controller->$INFOS_CONTROLLER;

            $ControllerAccessControlLogin = $ControllerAccessControl->$ControllerAccessControlLogin;
            $ControllerAccessControlPassword = $ControllerAccessControl->$ControllerAccessControlPassword;


            if(is_array($ControllerAccessControlLogin))
                $ControllerAccessControlLogin = $ControllerAccessControlLogin[count($ControllerAccessControlLogin) - 1];

            if(is_array($ControllerAccessControlPassword))
                $ControllerAccessControlPassword = $ControllerAccessControlPassword[count($ControllerAccessControlPassword) - 1];


            
            // TEST LOGIN & MDP
            if($ControllerAccessControlLogin == $data['user_name'] && selEncode($data['user_password'], ENCODE_METHOD) == $ControllerAccessControlPassword){
                unset($_SESSION[SESSION_REDIRECT]);
                $_SESSION[SESSION_ACCESS_CONTROL][(string)$ControllerName] = true;
                $_SESSION[SESSION_ACCESS_CONTROL]['login'] = $data['user_name'];
                header('location: '.SYS_FOLDER.substr($redirect, 1));
            }
            else {
                $this->_view->assign('return_access', Base::Load(CLASS_CORE_MESSAGE)->Generic('MESS_ERR_ACCESS_CONTROL_BAD_MDP'));
            }

        }
    }

    /** Disconnect user
     * @return void
     */
    public  function disconnect(){
        unset($_SESSION[SESSION_ACCESS_CONTROL]);    
    }
}

