<?php
namespace App\Model\Entity;

use \Core\Entity;

class Comment extends Entity
{
    protected $id;
    protected $blogPostId;
    protected $userId;
    protected $content;
    protected $addDate;
    protected $status = "pending";

    /**
     * Check if a comment is valid
     * 
     * @return bool
     */
    public function isValid()
    {
        return !(
            empty($this->content) ||
            empty($this->addDate) ||
            empty($this->status)
        );
    }

    // GETTERS
    public function getContent()
    {
        return $this->content;
    }

    public function getAddDate()
    {
        return $this->addDate;
    }

    public function getStatus()
    {
        return $this->status;
    }

    // SETTERS
    public function setContent($content)
    {
        if (is_string($content)) {
            $this->content = $content;
        }
    }

    public function setAddDate(\DateTime $addDate)
    {
        $this->addDate = $addDate;
    }

    public function setStatus($status)
    {
        if (is_string($status)) {
            $this->status = $status;
        }
    }
}