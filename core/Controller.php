<?php
namespace Core;

abstract class Controller
{
    protected $app;
    protected $action;
    protected $page;
    protected $managers;

    public function __construct(Application $app, $action)
    {
        $this->app = $app;
        $this->action = $action;
        $this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
    }

    /**
     * Call a child method to execute the action attribute
     *
     * @return void
     */
    public function execute()
    {
        $method = $this->action;
        $this->$method($this->app->getHttpRequest(), $this->app->getHttpResponse());
    }
}