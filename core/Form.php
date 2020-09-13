<?php
namespace Core;

class Form
{
    protected $entity;
    protected $fields = [];

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
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
     * This method creates a view representing the form.
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
}
