<?php
namespace App\FormBuilder;

use \Core\FormBuilder;
use \Core\InputField;
use \Core\TextareaField;
use \Core\MaxLengthValidator;
use \Core\NotNullValidator;
use \Core\EmailValidator;

class MessageFormBuilder extends FormBuilder
{
    /**
     * Build a message form
     *
     * @return void
     */
    public function build()
    {
        $this->form->addField(
            new InputField(
                [
                    'label' => 'Nom',
                    'type' => 'text',
                    'name' => 'name',
                    'placeholder' => 'Nom',
                    'required' => true,
                    'maxLength' => 60,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier un nom'
                        ),
                        new MaxLengthValidator(
                            'Le nom est trop long (60 caractères maximum)', 60
                        )
                    ]
                ]
            )
        )->addField(
            new InputField(
                [
                    'label' => 'Email',
                    'type' => 'email',
                    'name' => 'email',
                    'placeholder' => 'Email',
                    'required' => true,
                    'maxLength' => 255,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier une adresse e-mail'
                        ),
                        new EmailValidator(
                            'Merci de spécifier une adresse e-mail valide'
                        ),
                        new MaxLengthValidator(
                            'Votre adresse e-mail ne doit pas dépasser
                            255 caractères', 255
                        )
                    ]
                ]
            )
        )->addField(
            new TextareaField(
                [
                    'label' => 'Message',
                    'name' => 'message',
                    'placeholder' => 'Message',
                    'required' => true,
                    'maxLength' => 2000,
                    'rows' => 8,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier un message'
                        ),
                        new MaxLengthValidator(
                            'Le message est trop long (2000 caractères maximum)',
                            2000
                        ),
                    ]
                ]
            )
        );
    }
}
