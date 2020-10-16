<?php
namespace App\Model\Manager;

use \Core\Manager;
use \App\Model\Entity\User;

abstract class UserManager extends Manager
{
    /**
     * Return a user from the database
     * 
     * @param string $email Email address to use as a key
     * 
     * @return User
     */
    abstract public function get($email);

    /**
     * Add a new user in the database
     * 
     * @param User $user User to be added
     * 
     * @return void
     */
    abstract protected function add(User $user);

    /**
     * Update an existing user in the database
     * 
     * @param User $user User to be updated
     * 
     * @return void
     */
    abstract protected function update(User $user);

    /**
     * Delete an existing user from the database
     * 
     * @param string $email Email address to use as a key
     * 
     * @return void
     */
    abstract public function delete($email);

    /**
     * Check if a user exists
     * 
     * @param string $email Email address to use as a key
     * 
     * @return void
     */
    abstract public function exists($email);

    /**
     * Save a user in the database
     * 
     * @param User $user User to be saved
     * 
     * @return void
     */
    public function save(User $user)
    {
        if ($user->isValid()) {
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            
            $user->isNew() ? $this->add($user) : $this->update($user);
        }
    }
}