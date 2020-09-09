<?php
namespace Core;

abstract class Controller extends ApplicationComponent
{
    protected $module;
    protected $action;
    protected $view;
    protected $page;
    protected $managers;

    public function __constrcut(Application $app, $module, $action)
    {
        parent::__constrcut($app);

        $this->setModule($module);
        $this->setAction($action);
        $this->setView($action);
        $this->managers = new Managers('PDO', PDOFactory::getMysqlConnexion());
    }

    /**
     * This method calls the right method to execute the action attribute.
     *
     * @return null
     */
    public function execute()
    {
        $method = 'execute'.ucfirst($this->action);

        if (!is_callable([$this, $method])) {
            throw new Exception(
                'L\'action "'.$this->action.'" n\'est pas définie sur ce module.'
            );
        }

        $this->$method($this->app->httpRequest());
    }

    /**
     * This method returns the module attribute.
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * This method returns the action attribute.
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * This method returns the view attribute.
     *
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * This method returns the page attribute.
     *
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * This method returns the managers attribute.
     *
     * @return Managers
     */
    public function getManagers()
    {
        return $this->managers;
    }

    /**
     * This method set the module attribute.
     *
     * @param string $module Module to be set
     *
     * @return null
     */
    public function setModule($module)
    {
        if (!is_string($module) || empty($module)) {
            throw new \Exception('Le module n\'est pas valide');
        }
    }

    /**
     * This method set the action attribute.
     *
     * @param string $action Action to be set
     *
     * @return null
     */
    public function setAction($action)
    {
        if (!is_string($action) || empty($action)) {
            throw new \Exception('L\'action n\'est pas valide');
        }
    }

    /**
     * This method set the view attribute.
     *
     * @param string $view View to be set
     *
     * @return null
     */
    public function setView($view)
    {
        if (!is_string($view) || empty($view)) {
            throw new \Exception('La vue n\'est pas valide');
        }
    }
}
