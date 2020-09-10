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

    /**
     * This method returns the type attribute.
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * This method sets the type attribute.
     * 
     * @param string $type Type to be set
     * 
     * @return null
     */
    public function setType($type)
    {
        if (is_string($type)) {
            $this->type = $type;
        }
    }

    /** 
     * This method sets the maxLength attribute.
     * 
     * @param int $maxLength Maximum length to be set
     * 
     * @return null
     */
    public function setMaxLength($maxLength)
    {
        $this->maxLength = (int) $maxLength;
    }
}
