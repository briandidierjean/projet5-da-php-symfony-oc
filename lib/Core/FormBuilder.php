<?php
namespace Core;

abstract class FormBuilder
{
    protected $form;

    public function __construct(Entity $entity)
    {
        $this->setForm(new Form($entity));
    }

    /**
     * This method builds a form.
     *
     * @return null
     */
    abstract public function build();

    /**
     * This method returns the form attribute.
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * This method sets the form attribute.
     *
     * @param Form $form Form to be set
     *
     * @return null
     */
    public function setForm($form)
    {
        if ($form instanceof Form) {
            $this->form = $form;
        }
    }
}
