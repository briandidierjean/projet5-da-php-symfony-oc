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
        $this->page = $this->twig->render(
            'admin/index.html.twig',
            [
                'isSignedIn' => $this->authentication->isSignedIn()
            ]
        );

        $this->httpResponse->send($this->page);
    }
}
