<?php
namespace Core;

class InputField extends Field
{
    protected $type;

    /**
     * This method builds an HTML input field.
     * 
     * @return string
     */
    public function build()
    {
        $field = '<div class="control-group">
        <div class="form-group floating-label-form-group controls mb-0 pb-2">';

        $field .= '<label>'.$this->label.'</label><input class="form-control"
                  type="'.$this->type.'" name="'.$this->name.'"';
        
        if (!empty($this->placeholder)) {
            $field .= ' placeholder="'.($this->placeholder).'"';
        }

        if (!empty($this->value)) {
            $field .= ' value="'.htmlspecialchars($this->value).'"';
        }

        if (!empty($this->maxLength)) {
            $field .= ' maxlength="'.$this->maxLength.'"';
        }

        if (!empty($this->required) && $this->required == true) {
            $field .= ' required';
        }

        $field .= '>';

        if (!empty($this->errorMsg)) {
            $field .= '<div class="invalid-feedback">'.$this->errorMsg.'</div>';
        }
        return $field .= '</div>';
    }

    // SETTERS
    public function setType($type)
    {
        if (is_string($type)) {
            $this->type = $type;
        }
    }
}
