<?php
namespace Core;

abstract class Field
{
    use Hydrator;

    protected $label;
    protected $name;
    protected $value;
    protected $errorMsg;
    protected $validators = [];

    public function construct(array $options = [])
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

    /**
     * This method returns the label attribute.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * This method returns the name attribute.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * This method returns the value attribute.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * This method returns the errorMsg attribute.
     *
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    /**
     * This method returns the validators attribute.
     *
     * @return array
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * This method set the label attribute.
     *
     * @param string $label Label to be set
     *
     * @return null
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * This method set the name attribute.
     *
     * @param string $name name to be set
     *
     * @return null
     */
    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }
    }

    /**
     * This method set the value attribute.
     *
     * @param string $value value to be set
     *
     * @return null
     */
    public function setValue($value)
    {
        if (is_string($value)) {
            $this->value = $value;
        }
    }

    /**
     * This method set the validators attribute.
     *
     * @param array $validators validators to be set
     *
     * @return null
     */
    public function setvValidators(array $validators)
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
