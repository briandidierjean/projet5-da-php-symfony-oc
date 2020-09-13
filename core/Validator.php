<?php
namespace Validator;

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
     * @return void
     */
    abstract public function isValid();

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