<?php
namespace App\FormBuilder;

use \Core\FormBuilder;
use \Core\InputField;
use \Core\TextareaField;
use \Core\NotNullValidator;
use \Core\MaxLengthValidator;

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
                            'Merci de spécifier un titre'
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
                    'required' => true,
                    'maxLength' => 400,
                    'rows' => 5,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier un chapô'
                        ),
                        new MaxLengthValidator(
                            'Le chapô ne doit pas dépasser 400 caratères',
                            400
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
                    'rows' => 16,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier un contenu d\'article'
                        )
                    ]
                ]
            )
        );
    }
}