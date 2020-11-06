<?php
namespace Core;

abstract class Controller extends ApplicationComponent
{
    protected $httpRequest;
    protected $httpResponse;
    protected $action;
    protected $page;
    protected $managers;
    protected $authentication;

    public function __construct(Application $app, $action, $twig)
    {
        parent::__construct($app);

        $this->httpRequest = $app->getHttpRequest();
        $this->httpResponse = $app->getHttpResponse();
        $this->action = $action;
        $this->twig = $twig;
        $this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
        $this->authentication = $app->getAuthentication();
    }

    /**
     * Call a child method to execute the action attribute
     *
     * @return void
     */
    public function execute()
    {
        $method = $this->action;
        $this->$method();
    }
}