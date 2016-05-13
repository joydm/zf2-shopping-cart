<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 5/4/2016
 * Time: 4:04 PM
 */

namespace Product\Model;
use Zend\Db\TableGateway\TableGateway;

class CartTable
{
    protected $tableGateway;

    public function  __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCart($id)
    {
        $resultSet = $this->tableGateway->select(array('cart_id' => $id));
        return $resultSet->count() > 0 ? $resultSet->current() : null;
    }

    public function addCart($data)
    {
        $this->tableGateway->insert($data);
        return $this->tableGateway->getLastInsertValue();
    }

    public function updateCart($Cart)
    {
            $cart = array(
                'customer_id'       => isset($Cart['customer_id']) ? $Cart['customer_id'] : null,
                'sub_total'         => isset($Cart['subtotal']) ? $Cart['subtotal'] : null,
                'total_weight'         => isset($Cart['total_weight']) ? $Cart['total_weight'] : null,
                'company_name'      => isset($Cart['company_name']) ? $Cart['company_name'] : null,
                'email'             => isset($Cart['email']) ? $Cart['email'] : null,
                'phone'             => isset($Cart['phone']) ? $Cart['phone'] : null,
                'first_name'        => isset($Cart['first_name']) ? $Cart['first_name'] : null,
                'last_name'         => isset($Cart['last_name']) ? $Cart['last_name'] : null,
                'shipping_method'   => isset($Cart['shipping_method']) ? $Cart['shipping_method'] : null,
                'shipping_name'     => isset($Cart['name']) ? $Cart['name'] : null,
                'shipping_address1' => isset($Cart['address1']) ? $Cart['address1'] : null,
                'shipping_address2' => isset($Cart['address2']) ? $Cart['address2'] : null,
                'shipping_address3' => isset($Cart['address3']) ? $Cart['address3'] : null,
                'shipping_city'     => isset($Cart['city']) ? $Cart['city'] : null,
                'shipping_state'    => isset($Cart['state']) ? $Cart['state'] : null,
                'shipping_country'  => isset($Cart['country']) ? $Cart['country'] : null,
            );

        return $this->tableGateway->update($cart, array('cart_id' => $Cart['cart_id']));



    }





}