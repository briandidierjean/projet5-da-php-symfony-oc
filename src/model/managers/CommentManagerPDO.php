<?php
namespace App\Model\Manager;

use \App\Model\Entity\Comment;

class CommentManagerPDO extends CommentManager
{
    /**
     * Return a list of the comments
     *
     * @param int $blogPostId comment ID that owes the comments
     *
     * @return array
     */
    public function getList($blogPostId = '')
    {
        $comments = [];
        $field = '';
        $args = [];

        if (!empty($blogPostId)) {
            $field = 'WHERE blog_post_id = :blog_post_id';

            $args = [':blog_post_id' => $blogPostId];
        }

        $request = 'SELECT * FROM comments '.$field.' ORDER BY id DESC';

        $request = $this->dao->prepare($request);

        $request->execute($args);

        while ($data = $request->fetch(\PDO::FETCH_ASSOC)) {
            $comments[] = new Comment($data);
        }

        $request->closeCursor();

        return $comments;
    }

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
                blog_post_id, user_id, content, add_date
            ) VALUES(:blog_post_id, :user_id, :content, NOW())'
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

    /**
     * Check if a comment exists
     * 
     * @param int $id ID to use as a key
     * 
     * @return void
     */
    public function exists($id)
    {
        $request = $this->dao->prepare(
            'SELECT COUNT(*) FROM comments WHERE id = :id'
        );
        
        $request->bindValue(':id', $id, \PDO::PARAM_INT);

        $request->execute();

        return (bool) $request->fetchColumn();
    }

    /**
     * Validate a comment
     * 
     * @param in $id ID to use as a key
     * 
     * @return void
     */
    public function validate($id)
    {
        $request = $this->dao->prepare(
            'UPDATE comments
            SET status = \'validated\' WHERE id = :id' 
        );

        $request->bindValue(
            ':id',
            $id,
            \PDO::PARAM_INT
        );

        $request->execute();
    }
}
