<?php
namespace App\FormHandler;

use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Authentication;
use \Core\Form;
use \App\Model\Entity\BlogPost;
use \App\Model\Manager\BlogPostManager;

class BlogPostFormHandler
{
    protected $httpRequest;
    protected $httpResponse;
    protected $authentication;
    protected $form;
    protected $blogPostManager;

    public function __construct(
        HTTPRequest $httpRequest,
        HTTPResponse $httpResponse,
        Authentication $authentication,
        Form $form,
        BlogPostManager $blogPostManager
    ) {
        $this->httpRequest = $httpRequest;
        $this->httpResponse = $httpResponse;
        $this->authentication = $authentication;
        $this->form = $form;
        $this->blogPostManager = $blogPostManager;
    }

    /**
     * Process the form to add a blog post
     *
     * @return bool
     */
    public function addProcess()
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
            $token = $this->form->getData('token');
            if ($this->authentication->verifyToken($token)) {
                $blogPost = new BlogPost(
                    [
                        'userId' => $this->authentication->getId(),
                        'title' => $this->form->getData('title'),
                        'heading' => $this->form->getData('heading'),
                        'content' => $this->form->getData('content')
                    ]
                );

                $_GET['id'] =  $this->blogPostManager->save($blogPost);

                return true;
            }
        }

        return false;
    }

    /**
     * Process the form to update a blog post
     *
     * @return bool
     */
    public function updateProcess()
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
            $token = $this->form->getData('token');
            if ($this->authentication->verifyToken($token)) {
                $blogPost = $this->blogPostManager->get(
                    $this->httpRequest->getGet('id')
                );
        
                $blogPost->setUserId($this->authentication->getId());
                $blogPost->setTitle($this->form->getData('title'));
                $blogPost->setHeading($this->form->getData('heading'));
                $blogPost->setContent($this->form->getData('content'));

                $this->blogPostManager->save($blogPost);

                return true;
            }
        }

        return false;
    }
}
