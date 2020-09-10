<?php
namespace Core;

class FormHandler
{
    protected $form;
    protected $manager;
    protected $httpRequest;

    public function __construct(
        Form $form,
        Manager $manager,
        HTTPRequest $httpRequest
    ) {
        $this->setForm($form);
        $this->setManager($manager);
        $this->setHttpRequest($httpRequest);
    }

    /**
     * This method checks if a POST parameter is found,
     * and save form data to database.
     * 
     * @return bool
     */
    public function process()
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
            $this->manager->save($this->form->entity());

            return true;
        }

        return false;
    }

    /**
     * This method returns the form attribute
     * 
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * This method returns the manager attribute
     * 
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * This method returns the httpRequest attribute
     * 
     * @return HTTPRequest
     */
    public function getHttpRequest()
    {
        return $this->httpRequest;
    }

    /**
     * This method sets the form attribute.
     *
     * @param Form $form Form to be set
     *
     * @return null
     */
    public function setForm($form)
    {
        if ($form instanceof Form) {
            $this->form = $form;
        }
    }

    /**
     * This method sets the manager attribute.
     *
     * @param Manager $manager Manager to be set
     *
     * @return null
     */
    public function setManager($manager)
    {
        if ($manager instanceof Manager) {
            $this->manager = $manager;
        }
    }

    /**
     * This method sets the httpRequest attribute.
     *
     * @param HTTPRequest $httpRequest HTTP request to be set
     *
     * @return null
     */
    public function setHttpRequest($httpRequest)
    {
        if ($httpRequest instanceof HTTPRequest) {
            $this->httpRequest = $httpRequest;
        }
    }
}
