<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \App\Model\Entity\Comment;
use \App\FormBuilder\CommentFormBuilder;
use \App\FormHandler\AddCommentFormHandler;

class CommentController extends Controller
{
    /**
     * Add a comment
     *
     * @return void
     */
    public function add()
    {
        if (!$this->authentication->isSignedIn()) {
            $this->httpResponse->redirect('/sign-in');
        }

        $formData = [];

        if ($this->httpRequest->getMethod() == 'POST') {
            $formData = [
                'content' => $this->httpRequest->getPost('content')
            ];
        }

        $formBuilder = new CommentFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        $formHandler = new AddCommentFormHandler(
            $this->httpRequest,
            $this->httpResponse,
            $form,
            $this->managers->getManagerOf('Comment'),
            $this->authentication
        );

        if ($formHandler->process()) {
            $this->httpResponse->redirect(
                '/blog-post-'.$this->httpRequest->getGet('id')
            );
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'comment/add.html.twig',
            [
                'form' => $form->createView(),
                'isSignedIn' => $this->authentication->isSignedIn(),
                'blogPostId' => $this->httpRequest->getGet('id')
            ]
        );

        $this->httpResponse->send($this->page);
    }
}
