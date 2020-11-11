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
        $userManager = $this->managers->getManagerOf('User');

        $blogPosts = $blogPostManager->getList();
        $blogPostUsers = $userManager->getListFrom($blogPosts);

        $this->page = $this->twig->render(
            'blog-post/index.html.twig',
            [
                'blogPosts' => $blogPosts,
                'blogPostUsers' => $blogPostUsers
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
        $this->httpResponse->setSession(
            'prevURL',
            'blog-post-'.$this->httpRequest->getGet('id')
        );

        $blogPostManager = $this->managers->getManagerOf('BlogPost');
        $commentManager = $this->managers->getManagerOf('Comment');
        $userManager = $this->managers->getManagerOf('User');

        $blogPost = $blogPostManager->get($this->httpRequest->getGet('id'));
        $comments = $commentManager->getList($this->httpRequest->getGet('id'));
        $blogPostUser = $userManager->get($blogPost->getUserId());
        $commentUsers = $userManager->getListFrom($comments);

        $prevBlogPostId = $blogPostManager->getPrev(
            $blogPost->getUpdateDate()
        );
        $nextBlogPostId = $blogPostManager->getNext(
            $blogPost->getUpdateDate()
        );

        $this->page = $this->twig->render(
            'blog-post/show.html.twig',
            [
                'blogPost' => $blogPost,
                'comments' => $comments,
                'blogPostUser' => $blogPostUser,
                'commentUsers' => $commentUsers,
                'prevBlogPostId' => $prevBlogPostId,
                'nextBlogPostId' => $nextBlogPostId
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
            $this->httpResponse->setSession('prevURL', 'add-blog-post');
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
                'form' => $form->createView()
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
            $this->httpResponse->setSession(
                'prevURL',
                'update-blog-post'.$this->httpRequest->getGet('id')
            );
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
                'id' => $this->httpRequest->getGet('id')
            ]
        );

        $this->httpResponse->send($this->page);
    }

    /**
     * Delete a blog post
     *
     * @return void
     */
    public function delete()
    {
        if (!$this->authentication->isSignedIn()) {
            $this->httpResponse->setSession(
                'prevURL',
                'delete-blog-post'.$this->httpRequest->getGet('id')
            );
            $this->httpResponse->redirect('/sign-in');
        }

        if (!$this->authentication->isAdmin()) {
            $this->httpResponse->redirect401();
        }

        $blogPostManager = $this->managers->getManagerOf('BlogPost');
        $commentManager = $this->managers->getManagerOf('Comment');

        if (!$blogPostManager->exists($this->httpRequest->getGet('id'))) {
            $this->httpResponse->redirect404();
        }

        $blogPostManager->delete($this->httpRequest->getGet('id'));

        $this->httpResponse->redirect('/admin');
    }
}
