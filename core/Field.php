<?php
namespace Core;

abstract class Field
{
    use Hydrator;

    protected $label;
    protected $name;
    protected $value;
    protected $placeholder;
    protected $errorMsg;
    protected $validators = [];

    public function __construct(array $options = [])
    {
        if (!empty($options)) {
            $this->hydrate($options);
        }
    }

    /**
     * This method creates a view representing a field.
     *
     * @return string
     */
    abstract public function build();

    /**
     * This method checks if the field data sent by the user is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        foreach ($this->validators as $validator) {
            if (!$validator->isValid($this->value)) {
                $this->errorMsg = $validator->errorMsg();
                return false;
            }
        }

        return true;
    }

    // GETTERS
    public function getLabel()
    {
        return $this->label;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    public function getValidators()
    {
        return $this->validators;
    }

    // SETTERS
    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }
    }

    public function setValue($value)
    {
        if (is_string($value)) {
            $this->value = $value;
        }
    }

    public function setPlaceholder($placeholder)
    {
        if (is_string($placeholder)) {
            $this->placeholder = $placeholder;
        }
    }

    public function setValidators(array $validators)
    {
        foreach ($validators as $validator) {
            if ($validator instanceof Validator
                && !in_array($validator, $this->validators)
            ) {
                $this->validators[] = $validator;
            }
        }
    }
}
