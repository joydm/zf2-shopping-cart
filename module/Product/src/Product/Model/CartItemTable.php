<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 5/4/2016
 * Time: 5:25 PM
 */

namespace Product\Model;
use Zend\Db\Sql\Expression;
use Zend\Db\TableGateway\TableGateway;

class CartItemTable
{
    protected $tableGateway;
    protected $sqlExpression;

    public function  __construct(TableGateway $tableGateway, Expression $sqlExpression)
    {
        $this->tableGateway = $tableGateway;
        $this->sqlExpression = $sqlExpression;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCartItem($id)
    {
        $resultSet = $this->tableGateway->select(array('cart_item_id' => $id));
        return $resultSet->count() > 0 ? $resultSet->current() : null;
    }

    public function getCartItemsByCardId($id)
    {
        /*
         * SELECT cart_items.*, p.product_name, p.product_desc, p.thumbnail
         * FROM cart_items
         * LEFT JOIN products ON p.product_id = cart_items.product_id
         * WHERE cart_items.cart_id = $id
         */


        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
                'sum_quantity'      => new Expression('SUM(cart_items.qty)'),
                'sum_price'      => new Expression('SUM(cart_items.price)'),
                'cart_item_id'  =>  'cart_item_id',
                'cart_id'       =>  'cart_id',
                'product_id'    =>  'product_id',
                'weight'        =>  'weight',
                'qty'           =>  'qty',
                'unit_price'    =>  'unit_price',
                'price'         =>  'price'
            ));


        $select->join(array("p" => "products"), "p.product_id=cart_items.product_id", array("product_desc", "product_name", "product_thumbnail", "price"), "left");

        $select->where(array("cart_items.cart_id" => $id));
        $select->group(array("group" => "p.product_id"));

        //echo $select->getSqlString();die;

        $resultSet = $this->tableGateway->selectWith($select);

        $results = array();
        foreach ($resultSet as $r) {
            $results[] = $r;
        }

        return $results;
    }

    public function addCartItem($data)
    {
        $this->tableGateway->insert($data);
        return $this->tableGateway->getLastInsertValue();
    }


    public function getSubtotalByCartId($id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
            'sum_price'      => new Expression('SUM(cart_items.price)'),
        ));
        $select->where(array("cart_items.cart_id" => $id));
        $resultSet = $this->tableGateway->selectWith($select);
        $current = $resultSet->count() > 0 ? $resultSet->current() : null;

        return $current->sum_price;
    }

    public function getTotalWeightByCartId($id)
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
            'sum_weight'      => new Expression('SUM(cart_items.weight)'),
        ));
        $select->where(array("cart_items.cart_id" => $id));
        $resultSet = $this->tableGateway->selectWith($select);
        $current = $resultSet->count() > 0 ? $resultSet->current() : null;
        
        return $current->sum_weight;
    }





}