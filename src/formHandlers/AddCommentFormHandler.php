<?php
namespace App\FormHandler;

use \Core\FormHandler;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \Core\Form;
use \Core\Authentication;
use \App\Model\Entity\Comment;
use \App\Model\Manager\CommentManager;

class AddCommentFormHandler extends FormHandler
{
    protected $commentManager;
    protected $authentication;

    public function __construct(
        HTTPRequest $httpRequest,
        HTTPResponse $httpResponse,
        Form $form,
        CommentManager $commentManager,
        Authentication $authentication
    ) {
        parent::__construct($httpRequest, $httpResponse, $form);

        $this->commentManager = $commentManager;
        $this->authentication = $authentication;
    }

    public function process()
    {
        if ($this->httpRequest->getMethod() == 'POST' && $this->form->isValid()) {
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

        return false;
    }
}
