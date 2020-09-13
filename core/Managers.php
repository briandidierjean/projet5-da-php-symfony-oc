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
     * This method takes an entity name and returns the matched manager.
     *
     * @param string $entity Entity name to be matched
     *
     * @return Manager
     */
    public function getManagerOf($entity)
    {
        if (!is_string($entity) || empty($entity)) {
            throw new \Exception('L\'entité n\'est pas valide');
        }

        if (!isset($this->managers[$entity])) {
            $manager = '\\App\\Model\\Manager\\Manager'.$this->api;
            
            $this->managers[$entity] = new $manager($this->dao);
        }

        return $this->managers[$entity];
    }
}
