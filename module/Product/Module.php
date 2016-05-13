<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 4/29/2016
 * Time: 6:55 PM
 */

namespace Product;


use Product\Filter\ProductFilter;
use Product\Filter\ShippingFilter;
use Product\Form\ProductForm;
use Product\Form\ShippingForm;
use Product\Model\Cart;
use Product\Model\CartItem;
use Product\Model\CartItemTable;
use Product\Model\CartTable;
use Product\Model\Product;
use Product\Model\ProductTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;
use Zend\Stdlib\ArrayUtils;
use Zend\Db\Sql\Expression;

class Module
{
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }


    /**
     * Get site module config files
     * @return array
     *
     *  public function getConfig()
    {
    return include __DIR__ . '/config/module.config.php';
    }*/


    public function getConfig()
    {
        $config = array();

        // get config files
        $configFiles = array(
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/module.config.routes.php',
            __DIR__ . '/config/module.config.templates.php',
        );

        // Merge all module config options
        foreach($configFiles as $configFile) {
            $config = ArrayUtils::merge($config, include $configFile);
        }

        return $config;
    }


    public function getServiceConfig()
    {
        return array(
            'factories' =>  array(
                'Container' => function(){
                    return new Container('customer');
                },
                'ProductTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Product);
                    return new  TableGateway('products', $dbAdapter, null, $resultSetPrototype);
                },
                'ProductTable' => function($sm){
                    $ProductTableGateway = $sm->get('ProductTableGateway');
                    return new ProductTable($ProductTableGateway);
                },
                'Product' => function(){
                    return new Product();
                },
                'ProductForm' => function(){
                    return new ProductForm();
                },
                'ProductFilter' => function(){
                    return new ProductFilter();
                },

                'CartTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Cart());
                    return new  TableGateway('carts', $dbAdapter, null, $resultSetPrototype);
                },
                'CartTable' => function($sm){
                    $CartTableGateway = $sm->get('CartTableGateway');
                    return new CartTable($CartTableGateway);
                },
                'Cart' => function(){
                    return new Cart();
                },

                'CartItemTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new CartItem());
                    return new  TableGateway('cart_items', $dbAdapter, null, $resultSetPrototype);
                },
                'SqlExpression' => function(){
                    return new Expression();
                },
                'CartItemTable' => function($sm){
                    $CartItemTableGateway = $sm->get('CartItemTableGateway');
                    $SqlExpression = $sm->get('SqlExpression');
                    return new CartItemTable($CartItemTableGateway, $SqlExpression);
                },
                'CartItem' => function(){
                    return new CartItem();
                },
                
                'ShippingForm' => function(){
                    return new ShippingForm();
                },
                'ShippingFilter' => function(){
                    return new ShippingFilter();
                },



            )
        );
    }

}