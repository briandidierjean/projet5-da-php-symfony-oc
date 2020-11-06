<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \App\Model\Entity\BlogPost;
use \App\FormBuilder\BlogPostFormBuilder;
use \App\FormHandler\BlogPostFormHandler;

class BlogPostController extends Controller
{
    /**
     * Show the blog posts list
     *
     * @return void
     */
    public function index()
    {
        $blogPostManager = $this->managers->getManagerOf('BlogPost');

        $blogPosts = $blogPostManager->getList(0, 5);

        $this->page = $this->twig->render(
            'blog-post/index.html.twig',
            [
                'isSignedIn' => $this->authentication->isSignedIn(),
                'blogPosts' => $blogPosts
            ]
        );

        $this->httpResponse->send($this->page);
    }

    /**
     * Show a blog post
     *
     * @return void
     */
    public function show()
    {
        $blogPostManager = $this->managers->getManagerOf('BlogPost');
        $commentManager = $this->managers->getManagerOf('Comment');

        $blogPost = $blogPostManager->get($this->httpRequest->getGet('id'));
        $comments = $commentManager->getList($this->httpRequest->getGet('id'), 0, 5);

        $this->page = $this->twig->render(
            'blog-post/show.html.twig',
            [
                'isSignedIn' => $this->authentication->isSignedIn(),
                'blogPost' => $blogPost,
                'comments' => $comments
            ]
        );

        $this->httpResponse->send($this->page);
    }

    /**
     * Add a blog post
     *
     * @return void
     */
    public function add()
    {
        if (!$this->authentication->isSignedIn()) {
            $this->httpResponse->redirect('/sign-in');
        }

        if (!$this->authentication->isAdmin()) {
            $this->httpResponse->redirect401();
        }

        $formData = [];

        if ($this->httpRequest->getMethod() == 'POST') {
            $formData = [
                'title' => $this->httpRequest->getPost('title'),
                'heading' => $this->httpRequest->getPost('heading'),
                'content' => $this->httpRequest->getPost('content')
            ];
        }

        $formBuilder = new BlogPostFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        $formHandler = new BlogPostFormHandler(
            $this->httpRequest,
            $this->httpResponse,
            $this->authentication,
            $form,
            $this->managers->getManagerOf('BlogPost')
        );

        if ($formHandler->addProcess()) {
            $this->httpResponse->redirect(
                'blog-post-'.$this->httpRequest->getGet('id')
            );
        }

        $this->page = $this->twig->render(
            'blog-post/add.html.twig',
            [
                'form' => $form->createView(),
                'isSignedIn' => $this->authentication->isSignedIn()
            ]
        );

        $this->httpResponse->send($this->page);
    }

    /**
     * Update a blog post
     *
     * @return void
     */
    public function update()
    {
        if (!$this->authentication->isSignedIn()) {
            $this->httpResponse->redirect('/sign-in');
        }

        if (!$this->authentication->isAdmin()) {
            $this->httpResponse->redirect401();
        }

        $blogPostManager = $this->managers->getManagerOf('BlogPost');

        if (!$blogPostManager->exists($this->httpRequest->getGet('id'))) {
            $this->httpResponse->redirect404();
        }

        $blogPost = $blogPostManager->get($this->httpRequest->getGet('id'));

        $formData = [];

        $formData = [
                'title' => $blogPost->getTitle(),
                'heading' => $blogPost->getHeading(),
                'content' => $blogPost->getContent()
        ];

        if ($this->httpRequest->getMethod() == 'POST') {
            $formData = [
                'title' => $this->httpRequest->getPost('title'),
                'heading' => $this->httpRequest->getPost('heading'),
                'content' => $this->httpRequest->getPost('content')
            ];
        }

        $formBuilder = new BlogPostFormBuilder($formData);
        $formBuilder->build();

        $form = $formBuilder->getForm();

        $formHandler = new BlogPostFormHandler(
            $this->httpRequest,
            $this->httpResponse,
            $this->authentication,
            $form,
            $this->managers->getManagerOf('BlogPost')
        );

        if ($formHandler->updateProcess()) {
            $this->httpResponse->redirect(
                'blog-post-'.$this->httpRequest->getGet('id')
            );
        }

        $this->page = $this->twig->render(
            'blog-post/update.html.twig',
            [
                'form' => $form->createView(),
                'id' => $this->httpRequest->getGet('id'),
                'isSignedIn' => $this->authentication->isSignedIn()
            ]
        );

        $this->httpResponse->send($this->page);
    }
}
