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
     * @param Manager $manager Manager to use
     *
     * @return bool
     */
    public function saveDatabase(Manager $manager)
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
            $mail = new Mail(
                $this->entity->getEmail(),
                '',
                $this->entity->getMessage()
            );

            $mail->send();

            return true;
        }

        return false;
    }
}
