<?php
namespace App\FormBuilder;

use \Core\FormBuilder;
use \Core\InputeField;
use \Core\TextareaField;
use \Core\MaxLengthValidator;
use \Core\NotNullValidator;
use \Core\EmailValidator;

class MessageFormBuilder extends FormBuilder
{
    public function build()
    {
        $this->form->add(
            new InputField(
                [
                    'label' => 'Nom',
                    'name' => 'name',
                    'maxLength' => 30,
                    'validators' => [
                        new MaxLengthValidator(
                            'Le nom est trop long (30 caractères maximum)'
                        ),
                        new NotNullValidator(
                            'Merci de spécifier un nom'
                        )
                    ]
                ]
            )
        )->add(
            new InputField(
                [
                    'label' => 'Email',
                    'name' => 'email',
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier une adresse e-mail'
                        ),
                        new EmailValidator(
                            'Merci de spécifier une adresse e-mail valide'
                        )
                    ]
                ]
            )
        )->add(
            new TextareaField(
                [
                    'label' => 'Message',
                    'name' => 'message',
                    'validators' => [
                        new MaxLengthValidator(
                            'Le message est trop long (2000 caractères maximum)'
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
