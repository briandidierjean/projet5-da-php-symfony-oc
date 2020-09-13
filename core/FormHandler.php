<?php
namespace Core;

class FormHandler
{
    protected $form;
    protected $entity;
    protected $httpRequest;

    public function __construct(
        Form $form,
        Entity $entity,
        HTTPRequest $httpRequest
    ) {
        $this->form = $form;
        $this->entity = $entity;
        $this->httpRequest = $httpRequest;
    }

    /**
     * This method checks if a POST parameter is found,
     * and save form data to database.
     * 
     * @return bool
     */
    public function saveProcess(Manager $manager)
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
            $manager->save($this->entity);

            return true;
        }

        return false;
    }

    /**
     * This method checks if a POST parameter is found,
     * and send form data to an email adress.
     * 
     * @return bool
     */
    public function sendProcess()
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {

            $to = 'briandidierjean@outlook.com';
            $subject = 'Website Contact Form: '.$this->entity->getName();
            $body = $this->entity->getMessage();
            $header = 'From: noreply@briandidierjean.com';
            $header .= 'Reply-To:'.$this->entity->getEmail();

            mail($to, $subject, $body, $header);

            return true;
        }

        return false;
    }
}
