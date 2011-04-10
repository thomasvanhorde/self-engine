<?php

/**
 *  @author Thomas VAN HORDE
 *  @description Use PhpMailer
 */

/*
 * Dont forget config mail() function in your Apache server !
 */


if(file_exists(FOLDER_CLASS_EXT.'PHPMailer_v5.1/class.phpmailer.php'))
	require_once FOLDER_CLASS_EXT.'PHPMailer_v5.1/class.phpmailer.php';
elseif(file_exists(ENGINE_URL.FOLDER_CLASS_EXT.'PHPMailer_v5.1/class.phpmailer.php'))
	require_once ENGINE_URL.FOLDER_CLASS_EXT.'PHPMailer_v5.1/class.phpmailer.php';
else
    Base::Load(CLASS_CORE_MESSAGE)->Warning('ERR_LOAD_CLASS_PHPMAILER');


class Email extends PHPMailer{


    /**
     * @param  $FromMail
     * @param  $FromName
     * @param  $ToMail
     * @param  $Subject
     * @param  $content
     * @return bool
     */
    public function SimpleMailHTML($FromMail, $FromName, $ToMail, $Subject, $content){
        $this->IsHTML(true);
        return $this->SimpleMail($FromMail, $FromName, $ToMail, $Subject, $content);
    }

    /**
     * @param  $FromMail
     * @param  $FromName
     * @param  $ToMail
     * @param  $Subject
     * @param  $content
     * @return bool
     */
    public function SimpleMail($FromMail, $FromName, $ToMail, $Subject, $content){
        $this->IsHTML(true);
        $this->CharSet="utf8";
        $this->From=$FromMail;
        $this->FromName=$FromName;
        $this->AddAddress($ToMail);
        $this->Subject=$Subject;
        $this->Body=$content;
        if($this->Send())
            return true;
        else
            return false;
    }

}

