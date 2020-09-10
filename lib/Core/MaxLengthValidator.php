<?php
namespace Core;

class MaxLengthValidator extends Validator
{
    protected $maxLength;

    public function __construct($errorMsg, $maxLength)
    {
        parent::__construct($errorMsg);

        $this->setMaxLength($maxLength);
    }

    /**
     * This method checks if a form field value length is not superior
     * to the maximum length validator value.
     * 
     * @param string $value Value to be set
     * 
     * @return bool
     */
    public function isValid($value)
    {
        return strlen($value) <= $this->maxLength;
    }

    /**
     * This method returns the maxLength attribute.
     * 
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * This method sets the maxLength attribute.
     * 
     * @param int $maxLength Maximum length to be validated
     * 
     * @return null
     */
    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;
        if ($maxLength > 0) {
            $this->maxLength = $maxLength;
        }
    }
}