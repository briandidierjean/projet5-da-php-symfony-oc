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
     * This method calls the right method to execute the action attribute.
     *
     * @return void
     */
    public function execute()
    {
        $method = $this->action;

        if (!is_callable([$this, $method])) {
            throw new \Exception(
                'L\'action "'.$this->action.'" n\'est pas définie sur ce controller.'
            );
        }

        $this->$method($this->app->getHttpRequest());
    }

    // GETTERS
    public function getPage()
    {
        return $this->page;
    }
}