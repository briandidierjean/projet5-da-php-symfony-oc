<?php
namespace App\FormBuilder;

use \Core\FormBuilder;
use \Core\InputField;
use \Core\MaxLengthValidator;
use \Core\NotNullValidator;
use \Core\EmailValidator;

class SigningInFormBuilder extends FormBuilder
{
    /**
     * Build a signing in form
     *
     * @return void
     */
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
                    'maxLength' => 255,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre adresse e-mail'
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
        )->addField(
            new InputField(
                [
                    'id' => 'stay-sign-in',
                    'label' => 'Se souvenir de moi',
                    'type' => 'checkbox',
                    'name' => 'staySignedIn'
                ]
            )
        );
    }
}
