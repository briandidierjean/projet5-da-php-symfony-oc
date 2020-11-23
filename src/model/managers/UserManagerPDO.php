<?php
namespace App\Model\Manager;

use \App\Model\Entity\User;

class UserManagerPDO extends UserManager
{
    /**
     * Return a user from the database
     *
     * @param mixed $key ID or Email address to use as a key
     *
     * @return User
     */
    public function get($key)
    {
        $field = 'email';

        if (is_int($key)) {
            $field = 'id';
        }

        $request = $this->dao->prepare(
            'SELECT * FROM users WHERE '.$field.' = :key'
        );

        $request->bindValue(':key', $key);

        $request->execute();

        return new User($request->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * Take a blog posts or comments list and return a users list
     *
     * @param array $list Blog posts or comments to use as a key
     *
     * @return array
     */
    public function getListFrom($list)
    {
        $users = [];

        foreach ($list as $item) {
            $request = $this->dao->prepare(
                'SELECT * FROM users WHERE id = :id'
            );

            $request->bindValue(':id', $item->getUserId(), \PDO::PARAM_INT);

            $request->execute();

            while ($data = $request->fetch(\PDO::FETCH_ASSOC)) {
                $users[$item->getUserId()] = new User($data);
            }

            $request->closeCursor();
        }

        return $users;
    }

    /**
     * Add a new user in the database
     *
     * @param User $user User to be added
     *
     * @return void
     */
    protected function add(User $user)
    {
        $request = $this->dao->prepare(
            'INSERT INTO users(email, password, first_name, last_name)
            VALUES(:email, :password, :first_name, :last_name)'
        );

        $request->bindValue(':email', $user->getEmail(), \PDO::PARAM_STR);
        $request->bindValue(':password', $user->getPassword(), \PDO::PARAM_STR);
        $request->bindValue(':first_name', $user->getFirstName(), \PDO::PARAM_STR);
        $request->bindValue(':last_name', $user->getLastName(), \PDO::PARAM_STR);

        $request->execute();
    }

    /**
     * Update an existing user in the database
     *
     * @param User $user User to be updated
     *
     * @return void
     */
    protected function update(User $user)
    {
        $request = $this->dao->prepare(
            'UPDATE users
            SET email = :email, password = :password,
            first_name = :first_name, last_name = :last_name'
        );

        $request->bindValue(':email', $user->getEmail(), \PDO::PARAM_STR);
        $request->bindValue(':password', $user->getPassword(), \PDO::PARAM_STR);
        $request->bindValue(':first_name', $user->getFirstName(), \PDO::PARAM_STR);
        $request->bindValue(':last_name', $user->getLastName(), \PDO::PARAM_STR);

        $request->execute();
    }

    /**
     * Delete an existing user from the database
     *
     * @param string $email Email address to use as a key
     *
     * @return void
     */
    public function delete($email)
    {
        $request = $this->dao->prepare(
            'DELETE FROM users WHERE email = :email'
        );

        $request->bindValue(':email', $email, \PDO::PARAM_STR);

        $request->execute();
    }

    /**
     * Check if a user exists
     *
     * @param mixed $key ID or email address to use as a key
     *
     * @return bool
     */
    public function exists($key)
    {
        $field = 'email';

        if (is_int($key)) {
            $field = 'id';
        }

        $request = $this->dao->prepare(
            'SELECT COUNT(*) FROM users WHERE '.$field.' = :key'
        );
        
        $request->bindValue(':key', $key);

        $request->execute();

        return (bool) $request->fetchColumn();
    }
}
