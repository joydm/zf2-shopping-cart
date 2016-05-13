<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 5/4/2016
 * Time: 9:00 AM
 */

namespace Auth\Form;


use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('login');

        $this->add(array(
            'name' => 'action',
            'type' => 'Hidden',
            'attributes' => array(
                'value' => 'login',
            )
        ));

        $this->add(array(
            'name' => 'email',
            'type' => 'Email',
            'options' => array(
                'label' => 'Email ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes' => array(
                'id' => 'email',
            )

        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'options' => array(
                'label' => 'Password ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes' => array(
                'id' => 'password',
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'options'   => array(
                'label' => '  ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'submitLogin',
                'value'    => 'Login',
            )
        ));

    }

}