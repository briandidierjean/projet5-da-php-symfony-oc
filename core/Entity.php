<?php
namespace Core;

abstract class Entity
{
    use Hydrator;

    protected $id;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * Check if the entity has been added to the database
     * 
     * @return bool
     */
    public function isNew()
    {
        return empty($this->id);
    }

    // GETTERS
    public function getId()
    {
        return $this->id;
    }

    // SETTERS
    public function setId($id)
    {
        $this->id = (int) $id;
    }
}
