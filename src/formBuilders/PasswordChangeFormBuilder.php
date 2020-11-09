<?php
namespace App\FormBuilder;

use \Core\FormBuilder;
use \Core\InputField;
use \Core\MaxLengthValidator;
use \Core\NotNullValidator;
use \Core\PasswordValidator;

class PasswordChangeFormBuilder extends FormBuilder
{
    /**
     * Build a password change form
     *
     * @return void
     */
    public function build()
    {
        $this->form->addField(
            new InputField(
                [
                    'label' => 'Ancien mot de passe',
                    'type' => 'password',
                    'name' => 'formerPassword',
                    'placeholder' => 'Ancien mot de passe',
                    'required' => true,
                    'maxLength' => 50,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre ancien mot de passe'
                        )
                    ]
                ]
            )
        )->addField(
            new InputField(
                [
                    'label' => 'Nouveau mot de passe',
                    'type' => 'password',
                    'name' => 'newPassword',
                    'placeholder' => 'Nouveau mot de passe',
                    'required' => true,
                    'maxLength' => 50,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre nouveau mot de passe'
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
                    'label' => 'Nouveau mot de passe (confirmation)',
                    'type' => 'password',
                    'name' => 'newConfirmedPassword',
                    'placeholder' => 'Nouveau mot de passe (confirmation)',
                    'required' => true,
                    'maxLength' => 50,
                    'validators' => [
                        new NotNullValidator(
                            'Merci de spécifier votre nouveau mot de passe'
                        ),
                        new PasswordValidator(
                            'Votre mot de passe doit faire entre 8 et
                            50 caractères et contenir une majuscule, une minuscule,
                            un chiffre et un symbole'
                        )
                    ]
                ]
            )
        );
    }
}
