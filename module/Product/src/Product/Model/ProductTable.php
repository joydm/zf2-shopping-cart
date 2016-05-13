<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 4/29/2016
 * Time: 9:02 PM
 */

namespace Product\Model;


use Zend\Db\TableGateway\TableGateway;

class ProductTable
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

    public function getProduct($id)
    {
        $resultSet = $this->tableGateway->select(array('product_id' => $id));
        return $resultSet->count() > 0 ? $resultSet->current() : null;
    }


}