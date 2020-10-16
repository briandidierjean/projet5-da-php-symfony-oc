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
     * Check if a field value is valid
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