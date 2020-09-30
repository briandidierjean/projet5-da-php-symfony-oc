<?php
namespace Core;

use Symfony\Component\Yaml\Yaml;

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
     * @param Manager $manager Manager to use
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
     * and get entity from database.
     * 
     * @param Manager $manager Manager to use
     * @param string $attr Attribute to use
     * 
     * @return mixed
     */
    public function getProcess(Manager $manager, $attr)
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
            $method = 'get'.ucfirst($attr);
            return $entity = $manager->get($this->entity->$method());
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

            $mails = Yaml::parseFile(
                __DIR__.'/../config/mail.yaml'
            );

            $to = $mails['receiptAddress'];
            $subject = 'Website Contact Form: '.$this->entity->getName();
            $body = $this->entity->getMessage();
            $header = 'From: '.$mails['sendingAddress'];
            $header .= 'Reply-To:'.$this->entity->getEmail();

            mail($to, $subject, $body, $header);

            return true;
        }

        return false;
    }
}
