<?php
namespace App\Model\Manager;

use \App\Model\Entity\Comment;

class CommentManagerPDO extends CommentManager
{
    /**
     * Return a comment from the database
     *
     * @param int $id Comment ID to use as a key
     *
     * @return Comment
     */
    public function get($id)
    {
        $request = $this->dao->prepare(
            'SELECT * FROM comments WHERE id = :id'
        );

        $request->bindValue(':id', $id, \PDO::PARAM_INT);

        $request->execute();

        return new Comment($request->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * Add a new comment in the database
     *
     * @param Comment $comment Comment to be added
     *
     * @return void
     */
    protected function add(Comment $comment)
    {
        $request = $this->dao->prepare(
            'INSERT INTO comments(
                blog_post_id, user_id, content, add_date = NOW(), status
            ) VALUES(:blog_post_id, :user_id, :content, :status)'
        );

        $request->bindValue(
            ':blog_post_id',
            $comment->getBlogPostId(),
            \PDO::PARAM_INT
        );
        $request->bindValue(
            ':user_id',
            $comment->getUserId(),
            \PDO::PARAM_INT
        );
        $request->bindValue(
            ':content',
            $comment->getContent(),
            \PDO::PARAM_STR
        );
        $request->bindValue(
            ':status',
            $comment->getStatus(),
            \PDO::PARAM_STR
        );

        $request->execute();
    }

    /**
     * Update an existing comment in the database
     *
     * @param omment $comment Comment to be updated
     *
     * @return void
     */
    protected function update(Comment $comment)
    {
        $request = $this->dao->prepare(
            'UPDATE comments
            SET blog_post_id = :blog_post_id, user_id = :user_id, content = :content,
            add_date = NOW(), status = :status'
        );

        $request->bindValue(
            ':blog_post_id',
            $comment->getBlogPostId(),
            \PDO::PARAM_INT
        );
        $request->bindValue(
            ':user_id',
            $comment->getUserId(),
            \PDO::PARAM_INT
        );
        $request->bindValue(
            ':content',
            $comment->getContent(),
            \PDO::PARAM_STR
        );
        $request->bindValue(
            ':status',
            $comment->getStatus(),
            \PDO::PARAM_STR
        );

        $request->execute();
    }

    /**
     * Delete an existing comment from the database
     *
     * @param int $id Comment ID to use as a key
     *
     * @return void
     */
    public function delete($id)
    {
        $request = $this->dao->prepare(
            'DELETE FROM comments WHERE id = :id'
        );

        $request->bindValue(':id', $id, \PDO::PARAM_INT);

        $request->execute();
    }
}
