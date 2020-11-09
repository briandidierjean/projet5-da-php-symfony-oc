<?php
namespace App\Model\Manager;

use \Core\Manager;
use \App\Model\Entity\BlogPost;

abstract class BlogPostManager extends Manager
{
    /**
     * Return a list of the blog posts
     * 
     * @return array
     */
    abstract public function getList();

    /**
     * Return a blog post from the database
     * 
     * @param int $id Blog post ID to use as a key
     * 
     * @return BlogPost
     */
    abstract public function get($id);

    /**
     * Return a previous blog post to a blog post by date from the database
     * 
     * @param DateTime $date Date to use as a key
     * 
     * @return mixed
     */
    abstract public function getPrev($date);

    /**
     * Return a next blog post to a blog post by date from the database
     *
     * @param DateTime $date Date to use as a key
     * 
     * @return mixed
     */
    abstract public function getNext($date);

    /**
     * Add a new blog post in the database
     * 
     * @param BlogPost $blogPost Blog post to be added
     * 
     * @return int
     */
    abstract protected function add(BlogPost $blogPost);

    /**
     * Update an existing blog post in the database
     * 
     * @param BlogPost $blogPost Blog post to be updated
     * 
     * @return void
     */
    abstract protected function update(BlogPost $blogPost);

    /**
     * Delete an existing blog post from the database
     * 
     * @param int $id Blog post ID to use as a key
     * 
     * @return void
     */
    abstract public function delete($id);

    /**
     * Check if a blog post exists
     * 
     * @param int $id ID to use as a key
     * 
     * @return void
     */
    abstract public function exists($id);

    /**
     * Save a blog post in the database
     * 
     * @param BlogPost $blogPost Blog post to be saved
     * 
     * @return mixed
     */
    public function save(BlogPost $blogPost)
    {
        if ($blogPost->isValid()) {
            if ($blogPost->isNew()) {
                return $this->add($blogPost);
            }

            $this->update($blogPost);
        }
    }
}