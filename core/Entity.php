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
     * This method checks if an entity has been added to database.
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
