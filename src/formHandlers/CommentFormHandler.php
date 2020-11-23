<?php
namespace App\FormHandler;

use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Authentication;
use \Core\Form;
use \App\Model\Entity\Comment;
use \App\Model\Manager\CommentManager;

class CommentFormHandler
{
    protected $httpRequest;
    protected $httpResponse;
    protected $authentication;
    protected $form;
    protected $commentManager;

    public function __construct(
        HTTPRequest $httpRequest,
        HTTPResponse $httpResponse,
        Authentication $authentication,
        Form $form,
        CommentManager $commentManager
    ) {
        $this->httpRequest = $httpRequest;
        $this->httpResponse = $httpResponse;
        $this->authentication = $authentication;
        $this->form = $form;
        $this->commentManager = $commentManager;
    }

    /**
     * Process the form to add a comment
     *
     * @return bool
     */
    public function process()
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
            $token = $this->form->getData('token');
            if ($this->authentication->verifyToken($token)) {
                $comment  = new Comment(
                    [
                        'blogPostId' => $this->httpRequest->getGet('id'),
                        'userId' => $this->authentication->getId(),
                        'content' => $this->form->getData('content')
                    ]
                );
    
                $this->commentManager->save($comment);
    
                return true;
            }
        }

        return false;
    }
}
