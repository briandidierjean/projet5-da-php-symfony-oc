<?php
namespace Core;

abstract class FormBuilder
{
    protected $form;

    public function __construct(array $data)
    {
        $this->form = new Form($data);
    }

    /**
     * Build a form
     *
     * @return void
     */
    abstract public function build();

    // GETTERS
    public function getForm()
    {
        return $this->form;
    }
}
