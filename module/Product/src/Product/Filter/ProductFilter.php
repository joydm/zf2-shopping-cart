<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 4/30/2016
 * Time: 1:28 AM
 */

namespace Product\Filter;


use Zend\InputFilter\InputFilter;

class ProductFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(
            array(
                'name'      => 'quantity',
                'required'  => true,
                'filters'   => array(
                    array('name' => 'Int')
                )
            )
        );

    }
}