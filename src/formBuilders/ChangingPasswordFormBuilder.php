<?php
namespace App\FormBuilder;

use \Core\FormBuilder;
use \Core\InputField;
use \Core\MaxLengthValidator;
use \Core\NotNullValidator;
use \Core\PasswordValidator;

class SigningInFormBuilder extends FormBuilder
{
    public function build()
    {
        $this->form->addField(
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
                            'Merci de spécifier votre nouveau mot de passe'
                        ),
                        new PasswordValidator(
                            'Merci de spécifier votre nouveau mot de passe'
                        )
                    ]
                ]
            )
        )->addField(
            new InputField(
                [
                    'label' => 'Mot de passe',
                    'type' => 'password',
                    'name' => 'confirmedPassword',
                    'placeholder' => 'Mot de passe',
                    'required' => true,
                    'maxLength' => 30,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre mot de passe'
                        ),
                        new PasswordValidator(
                            'Merci de spécifier votre nouveau mot de passe'
                        )
                    ]
                ]
            )
        );
    }
}
