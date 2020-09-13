<?php
namespace Core;

abstract class FormBuilder
{
    protected $form;

    public function __construct(Entity $entity)
    {
        $this->form = new Form($entity);
    }

    /**
     * This method builds a form.
     *
     * @return void
     */
    abstract public function build();
}
