<?php
namespace App\Model\Manager;

use \App\Model\Entity\BlogPost;

class BlogPostManagerPDO extends BlogPostManager
{
    /**
     * Return a list of the blog posts
     *
     * @param int $start First blog post to get
     * @param int $limit The number of blog post to get
     *
     * @return array
     */
    public function getList($start = -1, $limit = -1)
    {
        $request = 'SELECT * FROM blog_posts ORDER BY id DESC';

        if ($start != -1 || $limit != -1) {
            $request .= ' LIMIT '.(int) $limit.' OFFSET '.(int) $start;
        }

        $request = $this->dao->query($request);

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
     * Add a new blog post in the database
     *
     * @param BlogPost $blogPost Blog post to be added
     *
     * @return void
     */
    protected function add(BlogPost $blogPost)
    {
        $request = $this->dao->prepare(
            'INSERT INTO blog_posts(
                user_id, title, heading, content, update_date = NOW()
            ) VALUES(:user_id, :title, :heading, :content)'
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
            'DELETE FROM blog_posts WHERE id = :id'
        );

        $request->bindValue(':id', $id, \PDO::PARAM_INT);

        $request->execute();
    }
}
