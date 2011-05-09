<?php
/**
 * User: Thomas
 * Date: 10/04/11
 * Time: 18:54
 */


if(file_exists(FOLDER_CLASS_EXT.'zend/Loader.php'))
	require_once FOLDER_CLASS_EXT.'zend/Loader.php';
elseif(file_exists(ENGINE_URL.FOLDER_CLASS_EXT.'zend/Loader.php'))
	require_once ENGINE_URL.FOLDER_CLASS_EXT.'zend/Loader.php';
else
    Base::Load(CLASS_CORE_MESSAGE)->Warning('ERR_LOAD_CLASS_GDATA');


class Youtube {

    const authenticationURL = 'https://www.google.com/accounts/ClientLogin';
    const tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';
    const clientIdentif = 'self::engine';
    private $_instance;

    function __construct(){

        Zend_Loader::loadClass('zend_Gdata_YouTube');
        Zend_Loader::loadClass('zend_Gdata_AuthSub');
        Zend_Loader::loadClass('zend_Gdata_ClientLogin');

        $httpClient = $this->clientLogin();

        $developerKey = selDecode(YOUTUBE_DEV_KEY);
        $applicationId = selDecode(YOUTUBE_APP_ID);
        $clientId = selDecode(YOUTUBE_CLIENT_ID);
        $this->_instance = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientId, $developerKey);
        $this->_instance ->setMajorProtocolVersion(2);
    }

    private function clientLogin(){
        return Zend_Gdata_ClientLogin::getHttpClient(
                      selDecode(YOUTUBE_LOGIN),
                      selDecode(YOUTUBE_PWD),
                      Zend_Gdata_YouTube::AUTH_SERVICE_NAME,
                      null,
                      self::clientIdentif,
                      null,
                      null,
                      Zend_Gdata_YouTube::CLIENTLOGIN_URL);
    }

    function uploadForm($redirect = false, $title = 'default title', $description = '', $category = 'Comedy', $tag = 'my Tag') {
        // Note that this example creates an unversioned service object.
        // You do not need to specify a version number to upload content
        // since the upload behavior is the same for all API versions.

        // create a new VideoEntry object
        $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();

        $myVideoEntry->setVideoTitle($title);
        $myVideoEntry->setVideoDescription($description);
        // The category must be a valid YouTube category!
        $myVideoEntry->setVideoCategory($category);

        // Set keywords. Please note that this must be a comma-separated string
        // and that individual keywords cannot contain whitespace
        $myVideoEntry->SetVideoTags($tag);

        $tokenArray = $this->_instance->getFormUploadToken($myVideoEntry, self::tokenHandlerUrl);
        $tokenValue = $tokenArray['token'];
        $postUrl = $tokenArray['url'];

        // place to redirect user after upload
        if($redirect)
            $nextUrl = $redirect;
        else
            $nextUrl = HTTP_HOST_REQUEST;

        // build the form
        $form = '<form action="'. $postUrl .'?nexturl='. $nextUrl .
                '" method="post" enctype="multipart/form-data">'.
                '<input name="file" type="file"/>'.
                '<input name="token" type="hidden" value="'. $tokenValue .'"/>'.
                '<input value="Envoyer une vidéo" type="submit" />'.
                '</form>';
        
        return $form;
    }

    function getVideoEntry($videoID, $full = false){
        return $this->_instance->getVideoEntry($videoID, null, $full);
    }

    function getVideo(){
        return $this->_instance->getuserUploads(YOUTUBE_LOGIN);
    }

    function getVideoFeed($location = Zend_Gdata_YouTube::VIDEO_URI)
    {
        return $this->_instance->getVideoFeed($location);
    }

    function updateEntry($videoEntry){
        return $this->_instance->updateEntry($videoEntry, $videoEntry->getEditLink()->getHref());
    }

    function delete($videoEntry){
        return $this->_instance->delete($videoEntry);
    }


}
