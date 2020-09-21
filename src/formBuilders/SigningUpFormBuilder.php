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
                        ),
                        new PasswordValidator(
                            'Merci de spécifier un mot de passe valide'
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
                    'placeholder' => 'Mot de passe',
                    'required' => true,
                    'maxLength' => 30,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre mot de passe'
                        ),
                        new PasswordValidator(
                            'Merci de spécifier un mot de passe valide'
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
                            'Merci de spécifier votre mot de passe'
                        )
                    ]
                ]
            )
        );
    }
}
