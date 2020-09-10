<?php
namespace Core;

class PasswordValidator extends Validator
{
    /**
     * This method checks if a field value matched the password format.
     *
     * @param string $value Value to be checked
     *
     * @return bool
     */
    public function isValid($value)
    {
        return preg_match(
            '^(?=.*[0-9])(?=.*[a-z])
            (?=.*[A-Z])(?=.*[*.!@$%^&(){}[]:;<>,.?/~_+-=|\]).{8,32}$',
            $value
        );
    }
}
