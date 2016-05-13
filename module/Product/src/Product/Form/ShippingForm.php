<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 5/5/2016
 * Time: 6:40 PM
 */

namespace Product\Form;


use Zend\Form\Form;

class ShippingForm extends  Form
{

    public function __construct($name=null)
    {

        parent::__construct('shipping');

        $this->add(array(
            'name'      => 'name',
            'type'      => 'Text',
            'options'   => array(
                'label' => 'Name ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'name',
            )
        ));

        $this->add(array(
            'name'      => 'address1',
            'type'      => 'Text',
            'options'   => array(
                'label' => 'Address1 ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'address1',
            )
        ));

        $this->add(array(
            'name'      => 'address2',
            'type'      => 'Text',
            'options'   => array(
                'label' => 'Address2 ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'address2',
            )
        ));

        $this->add(array(
            'name'      => 'address3',
            'type'      => 'Text',
            'options'   => array(
                'label' => 'Address3 ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'address3',
            )
        ));

        $this->add(array(
            'name'      => 'city',
            'type'      => 'Text',
            'options'   => array(
                'label' => 'City ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'city',
            )
        ));

        $this->add(array(
            'name'      => 'state',
            'type'      => 'Text',
            'options'   => array(
                'label' => 'State ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'state',
            )
        ));

        $this->add(array(
            'name'      => 'country',
            'type'      => 'Text',
            'options'   => array(
                'label' => 'Country ',
                'label_attributes' => array(
                    'class' => 'label-fixed'
                )
            ),
            'attributes'    => array(
                'id'    => 'country',
            )
        ));

        $this->add(array(
            'name' => 'shipping_method',
            'type' => 'Radio',
            'options' => array(
                'label' => 'Shipping Method ',
                'value_options' => array(
                    'Ground' => 'Ground Shipping',
                    'Expedited' => 'Expedited Shipping',
                ),
            ),

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
                'id'    => 'submitShipping',
                'value'    => 'Continue',
            )
        ));


    }
}