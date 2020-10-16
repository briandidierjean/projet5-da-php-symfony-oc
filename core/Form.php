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
     * Add a field
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
     * Add en error message to a field
     * 
     * @param string $errorMsg  Error message to show
     * @param string $fieldName Field name to affect the error message
     * 
     * @return void
     */
    public function addErrorMsg($errorMsg, $fieldName)
    {
        foreach ($this->fields as $field) {
            if ($field->getName() === $fieldName) {
                $field->setErrorMsg($errorMsg);
            }
        }
    }

    /**
     * Create a view representing the form
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
     * Check if the form data is valid
     *
     * @return bool
     */
    public function isValid()
    {
        $isValid = true;

        foreach ($this->fields as $field) {
            if (!$field->isValid()) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}
