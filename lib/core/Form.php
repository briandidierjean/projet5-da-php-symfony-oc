<?php
namespace Core;

class Form
{
    protected $entity;
    protected $fields = [];

    public function __construct(Entity $entity)
    {
        $this->setEntity($entity);
    }

    /**
     * This method adds a field to the form.
     *
     * @param Field $field Field to be added
     *
     * @return Form
     */
    public function addField(Field $field)
    {
        $attributeGetter = 'get' . $field->getName();
        $field->setValue($this->entity->$attributeGetter());

        $this->fields[] = $field;
        return $this;
    }

    /**
     * This method creates a view representing a field.
     *
     * @return string
     */
    public function createView()
    {
        $view = '';

        foreach ($this->fields as $field) {
            $view .= $field->build().'<br>';
        }

        return $view;
    }

    /**
     * This methods checks if the form data sent by the user is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        foreach ($this->fields as $field) {
            if (!$field->isValid()) {
                return false;
            }

            return true;
        }
    }

    /**
     * This methods returns the entity attribute.
     * 
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * This methods returns the fields attribute.
     * 
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * This methods set the entity attribute.
     * 
     * @param Entity $entity The entity to be set
     * 
     * @return null
     */
    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;
    }
}
