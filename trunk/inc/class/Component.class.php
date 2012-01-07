<?php
/**
 * Allows children to manage views inside controllers.
 *
 * @author  Thomas Van Horde
 * @author  Fabien Nouaillat
 * @package self-engine
 */

class Component
{
    public $_view;

    public function defaut()
    {
        exit(Base::Load(CLASS_CORE_MESSAGE)->Critic('ERR_DEFAULT_METHOD'));
    }

    /**
     * Assignes main view.
     */
    public function setConstruct()
    {
        $this->_view = Base::Load(CLASS_BASE)->getView();
    }

    /**
     * Changes the content type.
     *
     * @param  string $contentType
     */
    public function setContentType($contentType)
    {
        Base::Load(CLASS_BASE)->setContentType($contentType);
    }

    /**
     * @param  string $title
     * @param  mixed  $url
     * @param  mixed  $titleComplete
     */
    public function addBreadCrumb($title, $url = null, $titleComplete = null)
    {
        if (is_null($url)) {
            $url = HTTP_HOST_REQUEST;
        }

        Base::Load(CLASS_BASE)->addBreadCrumb($title, $url, $titleComplete);
    }
}