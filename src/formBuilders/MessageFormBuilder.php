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
                    'maxLength' => 30,
                    'validators' => [
                        new MaxLengthValidator(
                            'Le nom est trop long (30 caractères maximum)', 30
                        ),
                        new NotNullValidator(
                            'Merci de spécifier un nom'
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
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier une adresse e-mail', 30
                        ),
                        new EmailValidator(
                            'Merci de spécifier une adresse e-mail valide'
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
                    'rows' => 8,
                    'validators' => [
                        new MaxLengthValidator(
                            'Le message est trop long (2000 caractères maximum)', 200
                        ),
                        new NotNullValidator(
                            'Merci de spécifier un message'
                        )
                    ]
                ]
            )
        );
    }
}
