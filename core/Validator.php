<?php
namespace Core;

abstract class Validator
{
    protected $errorMsg;

    public function __construct($errorMsg)
    {
        $this->setErrorMsg($errorMsg);
    }

    /**
     * This methods checks if a form field is validated by the validator.
     * 
     * @param strong $value Value to be validated
     * 
     * @return bool
     */
    abstract public function isValid($value);

    // GETTERS
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    // SETTERS
    public function setErrorMsg($errorMsg)
    {
        if (is_string($errorMsg)) {
            $this->errorMsg = $errorMsg;
        }
    }
}