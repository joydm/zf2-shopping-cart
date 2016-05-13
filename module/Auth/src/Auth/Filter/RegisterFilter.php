<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 5/2/2016
 * Time: 7:38 PM
 */

namespace Auth\Filter;


use Zend\InputFilter\InputFilter;

class RegisterFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name'      => 'email',
            'required'  => true,
            'filters'   => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'      => 'password',
            'required'  => true,
            'filters'   => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'      => 'confirm_password',
            'required'  => true,
            'filters'   => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password',
                    ),
                ),
            )
        ));

        $this->add(array(
            'name'      => 'company_name',
            'required'  => false,
            'filters'   => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'      => 'first_name',
            'required'  => true,
            'filters'   => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'      => 'last_name',
            'required'  => true,
            'filters'   => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'      => 'phone',
            'required'  => false,
            'filters'   => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
                array('name' => 'Int'),
            ),
        ));

    }
}