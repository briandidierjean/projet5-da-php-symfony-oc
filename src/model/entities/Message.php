<?php
namespace App\Model\Entity;

use \Core\Entity;

class Message extends Entity
{
    protected $name;
    protected $email;
    protected $message;

    /**
     * This method checks if a message is valid.
     * 
     * @return bool
     */
    public function isValid()
    {
        return !(
            empty($this->name) ||
            empty($this->email) ||
            empty($this->message)
        );
    }

    // GETTERS
    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getMessage()
    {
        return $this->message;
    }

    // SETTERS
    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }
    }

    public function setEmail($email)
    {
        if (is_string($email)) {
            $this->email = $email;
        }
    }

    public function setMessage($message)
    {
        if (is_string($message)) {
            $this->message = $message;
        }
    }
}