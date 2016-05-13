<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 5/2/2016
 * Time: 7:31 PM
 */

namespace Auth\Form;


use Zend\Form\Form;

class RegisterForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('login');

        $this->add(array(
            'name' => 'action',
            'type' => 'Hidden',
            'attributes' => array(
                'value' => 'register',
            )
        ));

        $this->add(array(
            'name'      => 'email',
            'type'      => 'Email',
            'options'   => array(
                'label' => 'Email ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'email',
            )

        ));

        $this->add(array(
            'name'      => 'password',
            'type'      => 'Password',
            'options'   => array(
                'label' => 'Password ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
                'attributes'    => array(
                    'id'    => 'password',
            )
        ));

        $this->add(array(
            'name'      => 'confirm_password',
            'type'      => 'Password',
            'options'   => array(
                'label' => 'Confirm Password ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'confirm_password',
            )
        ));

        $this->add(array(
            'name'      => 'company_name',
            'type'      => 'Text',
            'options'   => array(
                'label' => 'Company Name ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'company_name',
            )
        ));

        $this->add(array(
            'name'      => 'first_name',
            'type'      => 'Text',
            'options'   => array(
                'label' => 'First Name ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'first_name',
            )
        ));

        $this->add(array(
            'name'      => 'last_name',
            'type'      => 'Text',
            'options'   => array(
                'label' => 'Last Name ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'last_name',
            )
        ));

        $this->add(array(
            'name'      => 'phone',
            'type'      => 'Text',
            'options'   => array(
                'label' => 'Phone ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'phone',
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
                'id'    => 'submitRegister',
                'value'    => 'Register',
            )
        ));

    }
}