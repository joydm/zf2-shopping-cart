<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 5/3/2016
 * Time: 12:31 AM
 */


namespace Auth\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Debug\Debug;

class CustomerTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function addCustomer(Customer $Customer)
    {
        $data = array(
            'customer_id'   => $Customer->customer_id,
            'email'         => $Customer->email,
            'password'      => $Customer->password,
            'company_name'  => $Customer->company_name,
            'first_name'    => $Customer->first_name,
            'last_name'     => $Customer->last_name,
            'phone'         => $Customer->phone,
        );

        $this->tableGateway->insert($data);
        return $this->tableGateway->getLastInsertValue();
    }

    public function getCustomer($id)
    {
        $resultSet = $this->tableGateway->select(array('customer_id' => $id));
        return $resultSet->count() > 0 ? $resultSet->current() : null;
    }

    public function loginCustomer($data)
    {
        $resultSet = $this->tableGateway->select(array('email' => $data["email"], 'password' => md5($data["password"])));
        return $resultSet->count() > 0 ? $resultSet->current() : null;
    }

    public function customerEmailExist($data)
    {
        $resultSet = $this->tableGateway->select(array('email' => $data->email));
        return $resultSet->count() > 0 ? true : false;
    }



}