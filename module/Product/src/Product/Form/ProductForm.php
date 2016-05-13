<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 4/30/2016
 * Time: 1:12 AM
 */

namespace Product\Form;


use Zend\Form\Form;

class ProductForm extends Form
{

    public function  __construct($name= null)
    {
        parent::__construct('product_details');

        $this->add(array(
            'name' => 'hdPrice',
            'type' => 'Hidden',
            'attributes'    => array(
                'id'        => 'hdPrice',
            )
        ));
        
        $this->add(array(
            'name' => 'quantity',
            'type' => 'Text',
            'attributes'    => array(
                'id'        => 'quantity',
                'value'     => '1'
            )
        ));

        $this->add(array(
            'name'          => 'submit',
            'type'          => 'Submit',
            'attributes'    => array(
                'value'     => 'Add to Cart',
                'id'        => 'btnAddToCart'
            )
        ));

    }
}