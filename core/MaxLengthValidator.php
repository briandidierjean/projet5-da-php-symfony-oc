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
     * Check if a field value length is not superior to a maximum length
     * 
     * @param string $value Value to be checked
     * 
     * @return bool
     */
    public function isValid($value)
    {
        return strlen($value) <= $this->maxLength;
    }

    // SETTERS
    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;
        if ($maxLength > 0) {
            $this->maxLength = $maxLength;
        }
    }
}