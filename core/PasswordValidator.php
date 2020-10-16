<?php
namespace Core;

class PasswordValidator extends Validator
{
    /**
     * Check if a field value matched the password format
     *
     * @param string $value Value to be checked
     *
     * @return bool
     */
    public function isValid($value)
    {
        return preg_match(
            '#^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,50})\S$#',
            $value
        );
    }
}
