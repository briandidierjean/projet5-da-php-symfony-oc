<?php
namespace App\Model\Manager;

use \App\Model\Entity\User;

class UserManagerPDO extends UserManager
{
    public function get($email)
    {
        $request = $this->dao->prepare(
            'SELECT * FROM users WHERE email = :email'
        );

        $request->bindValue(':email', $email, \PDO::PARAM_STR);

        $request->execute();

        return new User($request->fetch());

    }

    protected function add(User $user)
    {
        $request = $this->dao->prepare(
            'INSERT INTO users(email, password, first_name, last_name) VALUES(:email, :password, :first_name, :last_name)'
        );

        $request->bindValue(':email', $user->getEmail(), \PDO::PARAM_STR);
        $request->bindValue(':password', $user->getPassword(), \PDO::PARAM_STR);
        $request->bindValue(':first_name', $user->getFirstName(), \PDO::PARAM_STR);
        $request->bindValue(':last_name', $user->getLastName(), \PDO::PARAM_STR);

        $request->execute();
    }

    protected function update(User $user)
    {
        $request = $this->dao->prepare(
            'UPDATE users SET email = :email, password = :password, first_name = :first_name, last_name = :last_name'
        );

        $request->bindValue(':email', $user->getEmail(), \PDO::PARAM_STR);
        $request->bindValue(':password', $user->getPassword(), \PDO::PARAM_STR);
        $request->bindValue(':first_name', $user->getFirstName(), \PDO::PARAM_STR);
        $request->bindValue(':last_name', $user->getLastName(), \PDO::PARAM_STR);

        $request->execute();
    }

    public function delete($id)
    {
        $request = $this->dao->prepare(
            'DELETE FROM users WHERE id = :id'
        );

        $request->bindValue(':id', $user->getId(), \PDO::PARAM_STR);

        $request->execute();
    }

    public function exists($email)
    {
        $request = $this->dao->prepare(
            'SELECT * FROM users WHERE email = :email'
        );

        $request->bindValue(':email', $email, \PDO::PARAM_STR);

        $request->execute();
        
        return count($request->fetchAll());
    }
}