<?php
namespace App\FormHandler;

use \Core\FormHandler;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Form;
use \Core\Authentication;
use \App\Model\Entity\BlogPost;
use \App\Model\Manager\BlogPostManager;

class AddBlogPostFormHandler extends FormHandler
{
    protected $blogPostManager;
    protected $authentication;

    public function __construct(
        HTTPRequest $httpRequest,
        HTTPResponse $httpResponse,
        Form $form,
        BlogPostManager $blogPostManager,
        Authentication $authentication
    ) {
        parent::__construct($httpRequest, $httpResponse, $form);

        $this->blogPostManager = $blogPostManager;
        $this->authentication = $authentication;
    }

    /**
     * Process the form to add a blog post
     *
     * @return bool
     */
    public function process()
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
            $blogPost  = new BlogPost(
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

        return false;
    }
}
