<?php
namespace App\Model\Entity;

use \Core\Entity;

class User extends Entity
{
    protected $id;
    protected $role;
    protected $email;
    protected $password;
    protected $confirmedPassword;
    protected $firstName;
    protected $lastName;

    /**
     * This method checks if a user is valid.
     * 
     * @return bool
     */
    public function isValid()
    {
        return !(
            empty($this->email) ||
            empty($this->password) ||
            empty($this->firstName) ||
            empty($this->lastName)
        );
    }

    // GETTERS
    public function getRole()
    {
        return $this->role;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getConfirmedPassword()
    {
        return $this->confirmedPassword;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    // SETTERS
    public function setEmail($email)
    {
        if (is_string($email)) {
            $this->email = $email;
        }
    }

    public function setPassword($password)
    {
        if (is_string($password)) {
            $this->password = password_hash($password, PASSWORD_DEFAULT);
            /* echo $this->password;
            exit(); */
        }
    }

    public function setConfirmedPassword($confirmedPassword)
    {
        if (password_hash($confirmedPassword, PASSWORD_DEFAULT) === $this->password) {
            throw new \Exception('Les deux mots de passe ne correspondent pas');
        }
        $this->confirmedPassword = password_hash($confirmedPassword, PASSWORD_DEFAULT);
    }

    public function setFirstName($firstName)
    {
        if (is_string($firstName)) {
            $this->firstName = $firstName;
        }
    }

    public function setLastName($lastName)
    {
        if (is_string($lastName)) {
            $this->lastName = $lastName;
        }
    }
}