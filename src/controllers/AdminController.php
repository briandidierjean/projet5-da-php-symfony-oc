<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;
use \Core\HTTPResponse;

class AdminController extends Controller
{
    /**
     * Show the administration panel
     *
     * @return void
     */
    public function index()
    {
        $this->httpResponse->setSession('prevURL', 'admin');

        if (!$this->authentication->isSignedIn()) {
            $this->httpResponse->redirect('/sign-in');
        }

        if (!$this->authentication->isAdmin()) {
            $this->httpResponse->redirect401();
        }

        $blogPostManager = $this->managers->getManagerOf('BlogPost');
        $commentManager = $this->managers->getManagerOf('Comment');
        $userManager = $this->managers->getManagerOf('User');
        $blogPosts = $blogPostManager->getList();
        $comments = $commentManager->getList();
        $blogPostUsers = $userManager->getListFrom($blogPosts);
        $commentUsers = $userManager->getListFrom($comments);

        $this->page = $this->twig->render(
            'admin/index.html.twig',
            [
                'blogPosts' => $blogPosts,
                'comments' => $comments,
                'blogPostUsers' => $blogPostUsers,
                'commentUsers' => $commentUsers
            ]
        );

        $this->httpResponse->send($this->page);
    }
}
