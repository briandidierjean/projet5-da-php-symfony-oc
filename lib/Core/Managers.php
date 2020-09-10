<?php
namespace Core;

class Managers
{
    protected $api;
    protected $dao;
    protected $managers = [];

    public function __construct($api, $dao)
    {
        $this->api = $api;
        $this->dao = $dao;
    }

    /**
     * This method takes a module and returns the matched manager.
     *
     * @param string $module Module to be matched
     *
     * @return Manager
     */
    public function getManagerOf($module)
    {
        if (!is_string($module) || empty($module)) {
            throw new \Exception('Le module n\'est pas valide');
        }

        if (!isset($this->managers[$module])) {
            $manager = '\\Model\\'.ucfirst($module).'Manager'.$this->api;
            
            $this->managers[$module] = new $manager($this->dao);
        }

        return $this->managers[$module];
    }

    /**
     * This method return the api attribute
     *
     * @return string
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * This method return the dao attribute
     *
     * @return object
     */
    public function getDao()
    {
        return $this->dao;
    }

    /**
     * This method return the managers attribute
     *
     * @return array
     */
    public function getManagers()
    {
        return $this->managers;
    }
}
