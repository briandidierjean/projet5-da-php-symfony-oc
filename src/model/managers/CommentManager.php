<?php
namespace App\Model\Manager;

use \Core\Manager;
use \App\Model\Entity\Comment;

abstract class CommentManager extends Manager
{
    /**
     * Return a list of the comments
     *
     * @param int $blogPostId Blog post ID that owes the comments
     * @param int $start      First comment to get
     * @param int $limit      The number of comments get
     *
     * @return array
     */
    abstract public function getList($blogPostId, $start = -1, $limit = -1);

    /**
     * Return a comment from the database
     *
     * @param int $id Comment ID to use as a key
     *
     * @return Comment
     */
    abstract public function get($id);

    /**
     * Add a new comment in the database
     *
     * @param Comment $comment Comment to be added
     *
     * @return void
     */
    abstract protected function add(Comment $comment);

    /**
     * Update an existing comment in the database
     *
     * @param Comment $comment Comment to be updated
     *
     * @return void
     */
    abstract protected function update(Comment $comment);

    /**
     * Delete an existing comment from the database
     *
     * @param int $id Comment ID to use as a key
     *
     * @return void
     */
    abstract public function delete($id);

    /**
     * Check if a comment exists
     * 
     * @param int $id ID to use as a key
     * 
     * @return void
     */
    abstract public function exists($id);

    /**
     * Save a comment in the database
     *
     * @param Comment $comment Comment to be saved
     *
     * @return void
     */
    public function save(Comment $comment)
    {
        if ($comment->isValid()) {
            $comment->isNew() ? $this->add($comment) : $this->update($comment);
        }
    }
}
