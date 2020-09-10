<?php
namespace App\FrontOffice;

use \Core\Application;

class FrontOfficeApllication extends Applicaiton
{
    public function __construct()
    {
        parent::__construct();

        $this->name = 'FrontOffice';
    }

    /**
     * This method run the front office application. It takes a HTTP request
     * and returns a HTTP Response.
     * 
     * @return null
     */
    public function run()
    {
        $controller = $this->getController();
        $controller->execute();

        $this->httpResponse->send($controller->page());
    }
}