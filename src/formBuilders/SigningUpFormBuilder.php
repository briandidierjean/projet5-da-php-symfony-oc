<?php
namespace App\FormBuilder;

use \Core\FormBuilder;
use \Core\InputField;
use \Core\MaxLengthValidator;
use \Core\NotNullValidator;
use \Core\EmailValidator;
use \Core\PasswordValidator;

class SigningUpFormBuilder extends FormBuilder
{
    /**
     * Build a signing up form
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
                    'maxLength' => 256,
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
                        ),
                        new PasswordValidator(
                            'Votre mot de passe doit faire entre 8 et
                            50 caractères et contenir une majuscule, une minuscule,
                            un chiffre et un symbole'
                        )
                    ]
                ]
            )
        )->addField(
            new InputField(
                [
                    'label' => 'Mot de passe (confirmation)',
                    'type' => 'password',
                    'name' => 'confirmedPassword',
                    'placeholder' => 'Mot de passe (confirmation)',
                    'required' => true,
                    'maxLength' => 30,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre mot de passe'
                        ),
                        new PasswordValidator(
                            'Votre mot de passe doit faire entre 8 et
                            50 caractères et contenir une majuscule, une minuscule,
                            un chiffre et un symbole'
                        )
                    ]
                ]
            )
        )->addField(
            new InputField(
                [
                    'label' => 'Prénom',
                    'type' => 'text',
                    'name' => 'firstName',
                    'placeholder' => 'Prénom',
                    'required' => true,
                    'maxLength' => 30,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre prénom'
                        ),
                        new MaxLengthValidator(
                            'Votre prénom ne doit pas dépassé 30 caractères', 30
                        )
                    ]
                ]
            )
        )->addField(
            new InputField(
                [
                    'label' => 'Nom',
                    'type' => 'text',
                    'name' => 'lastName',
                    'placeholder' => 'Nom',
                    'required' => true,
                    'maxLength' => 30,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre nom'
                        ),
                        new MaxLengthValidator(
                            'Votre nom ne doit pas dépassé 30 caractères', 30
                        )
                    ]
                ]
            )
        );
    }
}
