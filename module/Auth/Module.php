<?php

namespace Auth;

use Auth\Filter\LoginFilter;
use Auth\Form\LoginForm;
use Auth\Form\RegisterForm;
use Auth\Filter\RegisterFilter;
use Auth\Model\Customer;
use Auth\Model\CustomerTable;
use Zend\Stdlib\ArrayUtils;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Auth\Service\CustomerService;

class Module
{


    public function onBootstrap(MvcEvent $e){

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $sessionManager = new SessionManager();
        $sessionManager->start();

        $application = $e->getParam('application');
        $Session = new Container();

        $viewModel = $application->getMvcEvent()->getViewModel();
        $viewModel->setVariable('first_name', $Session->first_name);


    }

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
     * {
     * return include __DIR__ . '/config/module.config.php';
     * }*/


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
        foreach ($configFiles as $configFile) {
            $config = ArrayUtils::merge($config, include $configFile);
        }

        return $config;
    }


    public function getServiceConfig(){
        return array(
            'factories' => array(
                'Container' => function(){
                    return new Container('customer');
                },
                'RegisterForm' => function(){
                    return new RegisterForm();
                },
                'RegisterFilter' => function(){
                    return new RegisterFilter();
                },
                'LoginForm' => function(){
                    return new LoginForm();
                },
                'LoginFilter' => function(){
                    return new LoginFilter();
                },

                'CustomerTableGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Customer());
                    return new TableGateway('customers', $dbAdapter, null, $resultSetPrototype);
                },
                'CustomerTable' => function($sm){
                    $CustomerTableGateway = $sm->get('CustomerTableGateway');
                    return new CustomerTable($CustomerTableGateway);
                },
                'Customer' => function(){
                    return new Customer();
                },
                'CustomerService' => function($sm){
                    $Session = $sm->get('Container');
                    return new CustomerService($Session);

                }

            )
        );
    }

}