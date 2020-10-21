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
     * Return a manager matching an entity name
     *
     * @param string $entity Entity name to be matched
     *
     * @return Manager
     */
    public function getManagerOf($entity)
    {
        if (!isset($this->managers[$entity])) {
            $manager = '\\App\\Model\\Manager\\'.$entity.'Manager'.$this->api;
            
            $this->managers[$entity] = new $manager($this->dao);
        }

        return $this->managers[$entity];
    }
}
