<?php
namespace InputField;

class InputField extends Field
{
    protected $type;
    protected $maxLength;

    /**
     * This method builds an HTML input field.
     * 
     * @return string
     */
    public function build()
    {
        $field = '';

        if (!empty($this->errorMsg)) {
            $field .= $this->errorMsg.'<br>';
        }

        $field .= '<label>'.$this->label.'</label><input type="'.
                  $this->type.'" name="'.$this->name.'"';

        if (!empty($this->value)) {
            $field .= ' value="'.htmlspecialchars($this->value).'"';
        }

        if (!empty($this->maxLength)) {
            $field .= ' maxlength="'.$this->maxLength.'"';
        }

        return $field .= '>';
    }

    // SETTERS
    public function setType($type)
    {
        if (is_string($type)) {
            $this->type = $type;
        }
    }

    public function setMaxLength($maxLength)
    {
        $this->maxLength = (int) $maxLength;
    }
}
