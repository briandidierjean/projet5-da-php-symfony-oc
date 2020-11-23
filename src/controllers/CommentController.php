<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \App\Model\Entity\Comment;
use \App\FormBuilder\CommentFormBuilder;
use \App\FormHandler\CommentFormHandler;

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
            $this->httpResponse->setSession(
                'prevURL',
                '/add-comment-'.$this->httpRequest->getGet('id')
            );
            $this->httpResponse->redirect('/sign-in');
        }

        $formData = [
            'token' => $this->authentication->generateToken()
        ];

        if ($this->httpRequest->getMethod() == 'POST') {
            $formData['content'] = $this->httpRequest->getPost('content');
        }

        $formBuilder = new CommentFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        $formHandler = new CommentFormHandler(
            $this->httpRequest,
            $this->httpResponse,
            $this->authentication,
            $form,
            $this->managers->getManagerOf('Comment')
        );

        if ($formHandler->process()) {
            $this->httpResponse->redirect(
                '/blog-post-'.$this->httpRequest->getGet('id')
            );
        }

        $this->page = $this->twig->render(
            'comment/add.html.twig',
            [
                'form' => $form->createView(),
                'blogPostId' => $this->httpRequest->getGet('id')
            ]
        );

        $this->httpResponse->send($this->page);
    }

    /**
     * Delete a comment
     * 
     * @return void
     */
    public function delete()
    {
        if (!$this->authentication->isSignedIn()) {
            $this->httpResponse->setSession(
                'prevURL',
                '/add-comment-'.$this->httpRequest->getGet('id')
            );
            $this->httpResponse->redirect('/sign-in');
        }

        if (!$this->authentication->isAdmin()) {
            $this->httpResponse->redirect401();
        }

        $commentManager = $this->managers->getManagerOf('Comment');

        $commentManager->delete($this->httpRequest->getGet('id'));

        if (!empty($this->httpRequest->getSession('prevURL'))) {
            $prevURL = $this->httpRequest->getSession('prevURL');
            $this->httpResponse->setSession('prevURL', '');
            $this->httpResponse->redirect($prevURL);
        }
        $this->httpResponse->redirect('/');
    }

    /**
     * Validate a comment
     * 
     * @return void
     */
    public function validate()
    {
        if (!$this->authentication->isSignedIn()) {
            $this->httpResponse->setSession(
                'prevURL',
                '/add-comment-'.$this->httpRequest->getGet('id')
            );
            $this->httpResponse->redirect('/sign-in');
        }

        if (!$this->authentication->isAdmin()) {
            $this->httpResponse->redirect401();
        }

        $commentManager = $this->managers->getManagerOf('Comment');

        $commentManager->validate($this->httpRequest->getGet('id'));

        if (!empty($this->httpRequest->getSession('prevURL'))) {
            $prevURL = $this->httpRequest->getSession('prevURL');
            $this->httpResponse->setSession('prevURL', '');
            $this->httpResponse->redirect($prevURL);
        }
        $this->httpResponse->redirect('/');
    }
}
