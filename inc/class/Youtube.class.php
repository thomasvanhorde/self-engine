<?php
/**
 * User: Thomas
 * Date: 10/04/11
 * Time: 18:54
 */


if(file_exists(FOLDER_CLASS_EXT.'Zend/Loader.php'))
	require_once FOLDER_CLASS_EXT.'Zend/Loader.php';
elseif(file_exists(ENGINE_URL.FOLDER_CLASS_EXT.'Zend/Loader.php'))
	require_once ENGINE_URL.FOLDER_CLASS_EXT.'Zend/Loader.php';
else
    Base::Load(CLASS_CORE_MESSAGE)->Warning('ERR_LOAD_CLASS_GDATA');


class Youtube {

    const authenticationURL = 'https://www.google.com/accounts/ClientLogin';
    private $_instance;

    function __construct(){

        Zend_Loader::loadClass('Zend_Gdata_YouTube');
        Zend_Loader::loadClass('Zend_Gdata_AuthSub');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

        $httpClient = $this->clientLogin();

        $developerKey = YOUTUBE_DEV_KEY;
        $applicationId = YOUTUBE_APP_ID;
        $clientId = YOUTUBE_CLIENT_ID;
        $this->_instance = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientId, $developerKey);
        $this->_instance ->setMajorProtocolVersion(2);
    }

    private function clientLogin(){
        $authenticationURL= self::authenticationURL;
        return Zend_Gdata_ClientLogin::getHttpClient(
                      YOUTUBE_LOGIN,
                      YOUTUBE_PWD,
                      'youtube',
                      null,
                      'MySource', // a short string identifying your application
                      null,
                      null,
                      $authenticationURL);
    }

    function uploadForm($redirect = false, $title = 'default title', $description = 'default description', $category = 'Comedy', $tag = 'my Tag') {
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

        $tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';
        $tokenArray = $this->_instance->getFormUploadToken($myVideoEntry, $tokenHandlerUrl);
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

    function updateEntry($videoEntry, $putUrl = null){
        return $this->_instance->updateEntry($videoEntry, $videoEntry->getEditLink()->getHref());
    }

    function delete($videoEntry){
        return $this->_instance->delete($videoEntry);
    }


}
