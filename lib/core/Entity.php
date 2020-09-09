<?php
namespace Core;

abstract class Entity
{
    use Hydratator;

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

    /**
     * This method return the id attribute.
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * This method set the id attribute.
     * 
     * @param int $id ID to be set
     * 
     * @return null
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }
}
