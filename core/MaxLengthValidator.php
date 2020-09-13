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

    // SETTERS
    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;
        if (!$maxLength > 0) {
            throw new \Exception(
                'La longueur maximale doit être un nombre supérieur à 0'
            );
        }
        $this->maxLength = $maxLength;
    }
}