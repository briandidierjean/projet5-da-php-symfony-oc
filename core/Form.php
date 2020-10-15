<?php
namespace Core;

class Form
{
    protected $data;
    protected $fields = [];

    public function __construct(array $data)
    {
        $this->data = $data;
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
        $fieldName = $field->getName();
        
        if (!empty($this->data[$fieldName])) {
            $field->setValue($this->data[$fieldName]);
        }

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
        /* echo '<pre>';print_r($this->fields);
        exit(); */
        foreach ($this->fields as $field) {
            if (!$field->isValid()) {
                return false;
            }

            return true;
        }
    }
}
