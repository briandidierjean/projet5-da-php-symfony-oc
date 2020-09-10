<?php
namespace Core;

class TextareaField extends Field
{
    protected $cols;
    protected $rows;

    /**
     * This method builds an HTML textarea field.
     *
     * @return string
     */
    public function build()
    {
        $field = '';

        if (!empty($this->errorMsg)) {
            $field .= $this->errorMsg.'<br>';
        }

        $field .= '<label>'.$this->label.
                  '</label><textarea name="'.$this->name.'"';

        if (!empty($this->cols)) {
            $field .= ' cols="'.$this->cols.'"';
        }

        if (!empty($this->rows)) {
            $field .= ' rows="'.$this->rows.'"';
        }

        $field .= '>';

        if (!emtpy($this->value)) {
            $field .= htmlspecialchars($this->value);
        }

        return $field.'</textarea>';
    }

    /**
     * This method return the cols attribute.
     * 
     * @return int
     */
    public function getCols()
    {
        return $this->cols;
    }

    /**
     * This method return the rows attribute.
     * 
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * This method sets the cols attribute.
     * 
     * @param int $cols Cols number to be set
     * 
     * @return null
     */
    public function setCols($cols)
    {
        $cols = (int) $cols;
        if ($cols > 0) {
            $this->cols = $cols;
        }
    }

    /**
     * This method sets the rows attribute.
     * 
     * @param int $rows rows number to be set
     * 
     * @return null
     */
    public function setRows($rows)
    {
        $rows = (int) $rows;
        if ($rows > 0) {
            $this->rows = $rows;
        }
    }
}
