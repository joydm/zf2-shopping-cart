<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 5/4/2016
 * Time: 5:25 PM
 */

namespace Product\Model;


class CartItem
{
    public $cart_item_id;
    public $cart_id;
    public $product_id;
    public $weight;
    public $qty;
    public $unit_price;
    public $price;

    public $sum_price;
    public $sum_weight;
    public $sum_quantity;
    public $product_name;
    public $product_desc;
    public $product_thumbnail;

    public function exchangeArray($data)
    {
        $this->cart_item_id         = (!empty($data['cart_item_id'])) ? $data['cart_item_id'] : null;
        $this->cart_id              = (!empty($data['cart_id'])) ? $data['cart_id'] : null;
        $this->product_id           = (!empty($data['product_id'])) ? $data['product_id'] : null;
        $this->weight               = (!empty($data['weight'])) ? $data['weight'] : null;
        $this->qty                  = (!empty($data['qty'])) ? $data['qty'] : null;
        $this->sum_price            = (!empty($data['sum_price'])) ? $data['sum_price'] : null;
        $this->sum_weight            = (!empty($data['sum_weight'])) ? $data['sum_weight'] : null;
        $this->sum_quantity         = (!empty($data['sum_quantity'])) ? $data['sum_quantity'] : null;
        $this->unit_price           = (!empty($data['unit_price'])) ? $data['unit_price'] : null;
        $this->price                = (!empty($data['price'])) ? $data['price'] : null;
        $this->product_name         = (!empty($data['product_name'])) ? $data['product_name'] : null;
        $this->product_desc         = (!empty($data['product_desc'])) ? $data['product_desc'] : null;
        $this->product_thumbnail    = (!empty($data['product_thumbnail'])) ? $data['product_thumbnail'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}