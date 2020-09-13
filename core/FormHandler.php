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
        $this->form = $form;
        $this->manager = $manager;
        $this->httpRequest = $httpRequest;
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
}
