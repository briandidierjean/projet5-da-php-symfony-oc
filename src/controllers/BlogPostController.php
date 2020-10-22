<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \App\Model\Entity\BlogPost;
use \App\FormBuilder\BlogPostFormBuilder;
use \App\FormHandler\AddBlogPostFormHandler;

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

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
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

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
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

        $userManager = $this->managers->getManagerOf('User');

        $user = $userManager->get($this->authentication->getEmail());

        if ($user->getRole() !== 'administrator') {
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

        $formHandler = new AddBlogPostFormHandler(
            $this->httpRequest,
            $this->httpResponse,
            $form,
            $this->managers->getManagerOf('BlogPost'),
            $this->authentication
        );

        if ($formHandler->process()) {
            $this->httpResponse->redirect(
                'blog-post-'.$this->httpRequest->getGet('id')
            );
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render(
            'blog-post/add.html.twig',
            [
                'form' => $form->createView(),
                'isSignedIn' => $this->authentication->isSignedIn()
            ]
        );

        $this->httpResponse->send($this->page);
    }
}
