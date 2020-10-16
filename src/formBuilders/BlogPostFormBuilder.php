<?php
namespace App\FormBuilder;

use \Core\FormBuilder;

class BlogPostFormBuilder extends FormBuilder
{
    /**
     * Build a blog post form
     *
     * @return void
     */
    public function build()
    {
        $this->form->addField(
            new InputField(
                [
                    'label' => 'Titre',
                    'type' => 'text',
                    'name' => 'title',
                    'placeholder' => 'Titre de l\'article',
                    'required' => true,
                    'maxLength' => 255,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre ancien mot de passe'
                        ),
                        new MaxLengthValidator(
                            'Le titre ne doit pas dépasser
                            255 caractères', 255
                        )
                    ]
                ]
            )
        )->addField(
            new TextareaField(
                [
                    'label' => 'Chapô',
                    'name' => 'heading',
                    'placeholder' => 'Chapô de l\'article',
                    'maxLength' => 2000,
                    'rows' => 8,
                    'validators' => [
                        new MaxLengthValidator(
                            'Le message est trop long (2000 caractères maximum)',
                            2000
                        )
                    ]
                ]
            )
        )->addField(
            new TextareaField(
                [
                    'class' => 'tinymce',
                    'label' => 'Contenu',
                    'name' => 'content',
                    'placeholder' => 'Contenu de l\'article',
                    'required' => true,
                    'rows' => 8,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre ancien mot de passe'
                        )
                    ]
                ]
            )
        );
    }
}