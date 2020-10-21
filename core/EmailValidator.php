<?php
namespace Core;

class EmailValidator extends Validator
{
    /**
     * Check if a field value matched the email format
     * 
     * @param string $value Value to be checked
     * 
     * @return bool
     */
    public function isValid($value)
    {
        return (filter_var($value, FILTER_VALIDATE_EMAIL));
    }
}