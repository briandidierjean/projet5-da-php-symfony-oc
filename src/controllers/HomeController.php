<?php
namespace App\Controller;

use \Core\Controller;
use \Core\HTTPRequest;

class HomeController extends Controller
{
    public function index(HTTPRequest $httpRequest)
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../views');
        $twig = new \Twig\Environment($loader);

        $this->page = $twig->render('home/index.html.twig', []);
    }
}