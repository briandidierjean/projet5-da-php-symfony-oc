<?php
namespace App\FormBuilder;

use \Core\FormBuilder;
use \Core\InputField;
use \Core\MaxLengthValidator;
use \Core\NotNullValidator;
use \Core\EmailValidator;

class SigningInFormBuilder extends FormBuilder
{
    public function build()
    {
        $this->form->addField(
            new InputField(
                [
                    'label' => 'Email',
                    'type' => 'email',
                    'name' => 'email',
                    'placeholder' => 'Email',
                    'required' => true,
                    'maxLength' => 30,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre adresse e-mail'
                        ),
                        new EmailValidator(
                            'Merci de spécifier une adresse e-mail valide'
                        )
                    ]
                ]
            )
        )->addField(
            new InputField(
                [
                    'label' => 'Mot de passe',
                    'type' => 'password',
                    'name' => 'password',
                    'placeholder' => 'Mot de passe',
                    'required' => true,
                    'maxLength' => 30,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre mot de passe'
                        )
                    ]
                ]
            )
        );
    }
}
