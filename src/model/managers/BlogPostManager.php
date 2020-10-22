<?php
namespace App\Model\Manager;

use \Core\Manager;
use \App\Model\Entity\BlogPost;

abstract class BlogPostManager extends Manager
{
    /**
     * Return a list of the blog posts
     * 
     * @param int $start First blog post to get
     * @param int $limit The number of blog post to get
     * 
     * @return array
     */
    abstract public function getList($start = -1, $limit = -1);

    /**
     * Return a blog post from the database
     * 
     * @param int $id Blog post ID to use as a key
     * 
     * @return BlogPost
     */
    abstract public function get($id);

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