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
     * @return null
     */
    abstract public function isValid();

    /**
     * This methods returns the errorMsg attribute.
     * 
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }

    /**
     * This methods set the errorMsg attribute.
     * 
     * @param string $errorMsg Error message to be set
     * 
     * @return null
     */
    public function setErrorMsg($errorMsg)
    {
        if (is_string($errorMsg)) {
            $this->errorMsg = $errorMsg;
        }
    }
}