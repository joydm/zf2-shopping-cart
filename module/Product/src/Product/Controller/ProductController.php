<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 4/29/2016
 * Time: 7:18 PM
 */

namespace Product\Controller;



use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\View\View;

class ProductController extends AbstractActionController
{
    public $response_message;

    public function indexAction()
    {

        $sm = $this->getServiceLocator();
        $ProductTable = $sm->get('ProductTable');
        $products = $ProductTable->fetchAll();

        $viewData = array(
            'products' => $products,
        );

        return new ViewModel($viewData);
    }

    public function viewAction()
    {

        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->redirect()->toRoute('product');
        }

        $sm             = $this->getServiceLocator();
        $ProductTable   = $sm->get('ProductTable');
        $productItem    = $ProductTable->getProduct($id);
        $ProductForm    = $sm->get('ProductForm');

        $request = $this->getRequest();

        if($request->isPost())
        {

            $ProductFilter = $sm->get('ProductFilter');
            $ProductForm->setInputFilter($ProductFilter);
            $ProductForm->setData($request->getPost());

            if($ProductForm->isValid())
            {

                $productDetails =  $ProductForm->getData();
                $itemQuantity = $productItem->stock_qty;
                $postQuantity = (!empty($productDetails['quantity'])) ? $productDetails['quantity'] : 1;
                $postPrice = (!empty($productDetails['hdPrice'])) ? number_format((float)$productDetails['hdPrice'], 2, '.', '') : $productItem->price;

                if($postQuantity > $itemQuantity)
                {
                    $this->response_message = "Given quantity is greater than the item stock.";
                }else
                {

                    $this->response_message = "";
                    $cartItemData = array(
                        'product_id'    => (int)$productItem->product_id,
                        'qty'           => (int)$postQuantity,
                        'weight'        => (int)$productItem->weight * $postQuantity,
                        'unit_price'    => (int)$productItem->price,
                        'price'         => $postPrice,
                    );
                    $this->addToCart($cartItemData);
                }
            }
        }

        $viewData = array(
            'productItem'   => $productItem,
            'form'          => $ProductForm,
            'response'      => $this->response_message
        );

        return new ViewModel($viewData);

    }


    public function addToCart($cartItemData)
    {

        $sm         = $this->getServiceLocator();
        $CartTable  = $sm->get('CartTable');
        $Session = $sm->get('Container');

        $date = date("Y-m-d H:i:s");
        $customerId = isset($Session->customer_id) ? $Session->customer_id : 0;

        $cartData = array(
            'customer_id'       => $customerId,
            'order_datetime'    => $date,
            'sub_total'          => 0,
            'taxable_amount'    => 0,
            'discount'          => 0,
            'tax'               => 0,
            'shipping_total'    => 0,
            'total_amount'      => 0,
            'total_weight'      => 0,
            'email'             => '',
            'first_name'        => '',
            'last_name'         => '',
            'shipping_method'   => '',
            'shipping_name'     => '',
            'shipping_address1' => '',
            'shipping_city'     => '',
            'shipping_state'    => '',
            'shipping_country'  => '',
        );

        $sessionCartId = isset($Session->cart_id) ? $Session->cart_id : null;
        if($sessionCartId == null)
        {
            $cartId = $CartTable->addCart($cartData);
            $Session->cart_id = $cartId;
            $cartItemData['cart_id'] = $cartId;
            $this->addToCartItem($cartItemData);
        }else
        {
            $cartItemData['cart_id'] = $sessionCartId;
            $this->addToCartItem($cartItemData);
        }
    }


    public function addToCartItem($cartItemData)
    {

        $sm = $this->getServiceLocator();
        $CartItemTable = $sm->get('CartItemTable');
        $CartItemTable->addCartItem($cartItemData);
        $this->redirect()->toRoute('product', array('action' => 'cart'));
    }

    public function cartAction()
    {

        $sm = $this->getServiceLocator();
        $CartItemTable = $sm->get('CartItemTable');
        $Session = $sm->get('Container');
        $sessionCartId = $Session->cart_id;

        $cartItems = $CartItemTable->getCartItemsByCardId($sessionCartId);
        $sessionCustomerId = (!empty($Session->customer_id)) ? true : false;
        $request = $this->getRequest();


        if($request->isPost())
        {
            if($sessionCustomerId)
            {
                $this->redirect()->toRoute('product', array('action' => 'shipping'));
            }else
            {
                $this->redirect()->toRoute('auth',
                    array('action' => 'index'),
                    array('query' => array('origin'=>'cart'))
                );
            }

        }

        return new ViewModel(array(
            'cartItems' => $cartItems,
        ));
    }

    public function shippingAction()
    {
        $sm = $this->getServiceLocator();
        $Session = $sm->get('Container');

        $sm             = $this->getServiceLocator();
        $ShippingForm   = $sm->get('ShippingForm');
        $ShippingFilter = $sm->get('ShippingFilter');
        $CustomerTable  = $sm->get('CustomerTable');
        $CartTable      = $sm->get('CartTable');
        $CartItemTable  = $sm->get('CartItemTable');
        $request        = $this->getRequest();

        if($request->isPost())
        {

            $ShippingForm->setInputFilter($ShippingFilter);
            $ShippingForm->setData($request->getPost());

            if($ShippingForm->isValid())
            {

                $shippingData = $ShippingForm->getData();
                $sessionCartId = $Session->cart_id;
                $sessionCustomerId = $Session->customer_id;
                $subtotal = $CartItemTable->getSubtotalByCartId($sessionCartId);
                $totalWeight = $CartItemTable->getTotalWeightByCartId($sessionCartId);
                $customer = $CustomerTable->getCustomer($sessionCustomerId);

                $shippingData['customer_id'] = $sessionCustomerId;
                $shippingData['cart_id'] = $sessionCartId;
                $shippingData['subtotal'] = $subtotal;
                $shippingData['total_weight'] = $totalWeight;
                $shippingData['first_name'] = $customer->first_name;
                $shippingData['last_name'] = $customer->last_name;
                $shippingData['email'] = $customer->email;
                $shippingData['company_name'] = $customer->company_name;
                $shippingData['phone'] = $customer->phone;

                if(!empty($sessionCartId)){

                    $CartTable->updateCart($shippingData);
                    $this->redirect()->toRoute('product', array('action' => 'payment'));
                }

            }

        }

        $viewData = array(
            'form'      => $ShippingForm,
        );

        return new ViewModel($viewData);

    }

    public function paymentAction()
    {
        return new ViewModel();
    }

}