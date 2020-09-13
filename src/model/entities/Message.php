<?php
namespace Message;

use \Core\Entity;

class Message extends Entity
{
    protected $name;
    protected $emailAddress;
    protected $content;

    /**
     * This method checks if a message is valid.
     * 
     * @return bool
     */
    public function isValid()
    {
        return !(
            empty($this->name) ||
            empty($this->emailAddress) ||
            empty($this->content)
        );
    }

    // GETTERS
    public function getName()
    {
        return $this->name;
    }

    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    public function getContent()
    {
        return $this->content;
    }

    // SETTERS
    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }
    }

    public function setEmailAddress($emailAddress)
    {
        if (is_string($emailAddress)) {
            $this->emailAddress = $emailAddress;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->content = $content;
        }
    }
}