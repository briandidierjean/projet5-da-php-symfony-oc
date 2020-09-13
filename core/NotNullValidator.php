<?php
namespace Core;

class NotNullValidator extends Validator
{
    /**
     * This methods checks a field value is empty.
     * 
     * @param string $value Value to be validated
     * 
     * @return bool
     */
    public function isValid($value)
    {
        return $value != '';
    }
}