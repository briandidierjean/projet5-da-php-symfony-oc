<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;
use \Core\HTTPResponse;
use \App\Model\Entity\BlogPost;

class BlogPostController extends Controller
{
    /**
     * Show the blog page with the blog posts
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
            'blog/index.html.twig',
            [
                'isSignedIn' => $this->authentication->isSignedIn(),
                'blogPosts' => $blogPosts
            ]
        );

        $this->httpResponse->send($this->page);
    }
}
