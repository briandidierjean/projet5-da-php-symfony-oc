<?php
namespace App\Model\Manager;

use \App\Model\Entity\BlogPost;

class BlogPostManagerPDO extends BlogPostManager
{
    /**
     * Return a list of the blog posts
     *
     * @return array
     */
    public function getList()
    {
        $blogPosts = [];

        $request = $this->dao->query(
            'SELECT * FROM blog_posts ORDER BY update_date DESC'
        );

        while ($data = $request->fetch(\PDO::FETCH_ASSOC)) {
            $blogPosts[] = new BlogPost($data);
        }

        $request->closeCursor();

        return $blogPosts;
    }

    /**
     * Return a blog post from the database
     *
     * @param int $id Blog post ID to use as a key
     *
     * @return BlogPost
     */
    public function get($id)
    {
        $request = $this->dao->prepare(
            'SELECT * FROM blog_posts WHERE id = :id'
        );

        $request->bindValue(':id', $id, \PDO::PARAM_INT);

        $request->execute();

        $blogPost = new BlogPost($request->fetch(\PDO::FETCH_ASSOC));

        return $blogPost;
    }

    /**
     * Return a previous blog post to a blog post by date from the database
     * 
     * @param DateTime $date Date to use as a key
     * 
     * @return mixed
     */
    public function getPrev($date)
    {
        $request = $this->dao->prepare(
            'SELECT id FROM blog_posts
            WHERE update_date < :update_date ORDER BY update_date DESC'
        );

        $request->bindValue(':update_date', $date->format('Y-m-d H:i:s'));

        $request->execute();

        $data = $request->fetch(\PDO::FETCH_ASSOC);

        if (isset($data['id'])) {
            return $data['id'];
        }

        return false;
    }

    /**
     * Return a next blog post to a blog post by date from the database
     *
     * @param DateTime $date Date to use as a key
     * 
     * @return mixed
     */
    public function getNext($date)
    {
        $request = $this->dao->prepare(
            'SELECT id FROM blog_posts
            WHERE update_date > :update_date ORDER BY update_date'
        );

        $request->bindValue(':update_date', $date->format('Y-m-d H:i:s'));

        $request->execute();

        $data = $request->fetch(\PDO::FETCH_ASSOC);

        if (isset($data['id'])) {
            return $data['id'];
        }

        return false;
    }

    /**
     * Add a new blog post in the database
     *
     * @param BlogPost $blogPost Blog post to be added
     *
     * @return int
     */
    protected function add(BlogPost $blogPost)
    {
        $request = $this->dao->prepare(
            'INSERT INTO blog_posts(
                user_id, title, heading, content, update_date
            ) VALUES(:user_id, :title, :heading, :content, NOW())'
        );

        $request->bindValue(
            ':user_id',
            $blogPost->getUserId(),
            \PDO::PARAM_INT
        );
        $request->bindValue(
            ':title',
            $blogPost->getTitle(),
            \PDO::PARAM_STR
        );
        $request->bindValue(
            ':heading',
            $blogPost->getHeading(),
            \PDO::PARAM_STR
        );
        $request->bindValue(
            ':content',
            $blogPost->getContent(),
            \PDO::PARAM_STR
        );

        $request->execute();
        
        return $this->dao->lastInsertId();
    }

    /**
     * Update an existing blog post in the database
     *
     * @param BlogPost $blogPost Blog post to be updated
     *
     * @return void
     */
    protected function update(BlogPost $blogPost)
    {
        $request = $this->dao->prepare(
            'UPDATE blog_posts
            SET user_id = :user_id, title = :title,
            heading = :heading, content = :content, update_date = NOW()'
        );

        $request->bindValue(':user_id', $blogPost->getUserId(), \PDO::PARAM_INT);
        $request->bindValue(':title', $blogPost->getTitle(), \PDO::PARAM_STR);
        $request->bindValue(':heading', $blogPost->getHeading(), \PDO::PARAM_STR);
        $request->bindValue(':content', $blogPost->getContent(), \PDO::PARAM_STR);

        $request->execute();
    }

    /**
     * Delete an existing blog post from the database
     *
     * @param int $id Blog post ID to use as a key
     *
     * @return void
     */
    public function delete($id)
    {
        $request = $this->dao->prepare(
            'DELETE FROM comments WHERE blog_post_id = :blog_post_id'
        );

        $request->bindValue(':blog_post_id', $id, \PDO::PARAM_INT);

        $request->execute();

        $request = $this->dao->prepare(
            'DELETE FROM blog_posts WHERE id = :id'
        );

        $request->bindValue(':id', $id, \PDO::PARAM_INT);

        $request->execute();
    }

    /**
     * Check if a blog post exists
     * 
     * @param int $id ID to use as a key
     * 
     * @return void
     */
    public function exists($id)
    {
        $request = $this->dao->prepare(
            'SELECT COUNT(*) FROM blog_posts WHERE id = :id'
        );
        
        $request->bindValue(':id', $id, \PDO::PARAM_INT);

        $request->execute();

        return (bool) $request->fetchColumn();
    }
}
