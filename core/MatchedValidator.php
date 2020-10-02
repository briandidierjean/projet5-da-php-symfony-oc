<?php
namespace Core;

class MatchedValidator extends Validator
{

    /**
     * This method checks if a value match a pattern.
     * 
     * @param string $value   Value to be validated
     * @param string $pattern Pattern to be matched
     * 
     * @return bool
     */
    static public function isValid($value, $pattern)
    {
        return preg_match($pattern, $value);
    }
}