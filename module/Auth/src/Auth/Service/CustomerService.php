<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 5/4/2016
 * Time: 10:55 AM
 */

namespace Auth\Service;


class CustomerService
{
    public $Session;

    public function __construct($Session)
    {
        $this->Session = $Session;
    }

    public function isUserLoggedIn(){
        return isset($this->Session->customer_id) ? true : false;
    }


}