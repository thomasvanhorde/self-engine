<?php

$loadParent = function ($file) {
    if (file_exists(FOLDER_CLASS_EXT.$file)) {
        require_once FOLDER_CLASS_EXT.$file;
    } elseif (file_exists(ENGINE_URL.FOLDER_CLASS_EXT.$file)) {
        require_once ENGINE_URL.FOLDER_CLASS_EXT.$file;
    } else {
       throw new Exception(sprintf('Unable to find %s.', $file));
    }
};
$loadParent('PHPMailer_v5.1/class.phpmailer.php');

/**
 * Extends PHPMailer.
 *
 * Do not forget to configure the mail() function on your Apache server.
 *
 * @author  Thomas Van Horde
 * @author  Fabien Nouaillat
 * @package self-engine
 */
class Email extends PHPMailer
{
    /**
     * @todo   Stop using it: it just redeclares SimpleMail().
     *
     * @param  $FromMail
     * @param  $FromName
     * @param  $ToMail
     * @param  $Subject
     * @param  $content
     *
     * @return bool
     */
    public function SimpleMailHTML($FromMail, $FromName, $ToMail, $Subject, $content)
    {
        return $this->SimpleMail($FromMail, $FromName, $ToMail, $Subject, $content);
    }

    /**
     * @param  $FromMail
     * @param  $FromName
     * @param  $ToMail
     * @param  $Subject
     * @param  $content
     *
     * @return bool
     */
    public function SimpleMail($FromMail, $FromName, $ToMail, $Subject, $content)
    {
        $this->IsHTML(true);
        $this->CharSet  = "utf8";
        $this->From     = $FromMail;
        $this->FromName = $FromName;
        $this->AddAddress($ToMail);
        $this->Subject  = $Subject;
        $this->Body     = $content;

        return $this->Send();
    }
}