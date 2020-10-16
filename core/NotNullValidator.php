<?php
namespace Core;

class NotNullValidator extends Validator
{
    /**
     * Check a field value is empty
     * 
     * @param string $value Value to be checked
     * 
     * @return bool
     */
    public function isValid($value)
    {
        return $value != '';
    }
}