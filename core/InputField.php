<?php
namespace Core;

class InputField extends Field
{
    protected $type;
    protected $field;

    /**
     * Build an HTML input field
     *
     * @return string
     */
    public function build()
    {
        if ($this->type == 'checkbox') {
            $this->field = '<div class="control-group">
            <div class="form-group controls mb-0 pb-2">
             <div class="form-check">
            <input class="form-check-input"
            type="checkbox" id="'.$this->id.'">
            <label class="form-check-label" for="'.$this->id.'">
            '.$this->label.'</label>
            </div>
            </div>';
        } else {
            $this->field = '<div class="control-group">
            <div class="form-group floating-label-form-group controls mb-0 pb-2">';

            if (!empty($this->errorMsg)) {
                $this->field .= '<label>'.$this->label.'</label>
                <input class="form-control is-invalid"
                type="'.$this->type.'" name="'.$this->name.'"';
            } else {
                $this->field .= '<label>'.$this->label.'</label>
                <input class="form-control"
                type="'.$this->type.'" name="'.$this->name.'"';
            }
        
            if (!empty($this->placeholder)) {
                $this->field .= ' placeholder="'.($this->placeholder).'"';
            }

            if (!empty($this->value)) {
                $this->field .= ' value="'.htmlspecialchars($this->value).'"';
            }

            if (!empty($this->maxLength)) {
                $this->field .= ' maxlength="'.$this->maxLength.'"';
            }

            if (!empty($this->required) && $this->required == true) {
                $this->field .= ' required';
            }

            $this->field .= '>';

            if (!empty($this->errorMsg)) {
                $this->field .= '<div class="invalid-feedback">'
                .$this->errorMsg.'</div>';
            }
        }
        return $this->field .= '</div>';
    }

    // SETTERS
    public function setType($type)
    {
        if (is_string($type)) {
            $this->type = $type;
        }
    }
}
