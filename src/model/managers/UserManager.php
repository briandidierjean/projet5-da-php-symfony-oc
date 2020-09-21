<?php
namespace Model\Manager;

use \Core\Manager;
use \App\Model\Entity\User;

abstract class UserManager extends Manager
{
    /**
     * This method gets a user from the database.
     * 
     * @param mixed $email Email address to use as a filter
     * 
     * @return User
     */
    abstract public function get($email);

    /**
     * This method adds a new user in the database.
     * 
     * @param User $user User to be added.
     * 
     * @return void
     */
    abstract public function add(User $user);

    /**
     * This method updates an existing user in the database.
     * 
     * @param User $user User to be updated.
     * 
     * @return void
     */
    abstract public function update(User $user);

    /**
     * This method deletes an existing user from the database.
     * 
     * @param int $id User id to be deleted.
     * 
     * @return void
     */
    abstract public function delete($id);

    /**
     * This method checks takes an email address and checks
     * if a user is associated to that email.
     * 
     * @param string $email Email address to be checked.
     * 
     * @return bool
     */
    abstract public function exists($email);

    /**
     * This method save a user in the database.
     * 
     * @param User $user User to be saved.
     * 
     * @return void
     */
    public function save(User $user)
    {
        if ($user->isValid()) {
            $user->isNew() ? $this->add($user) : $this->update($user);
        } else {
            throw new \Exception('L\'utilisateur doit être valide pour être enregistré');
        }
    }
}