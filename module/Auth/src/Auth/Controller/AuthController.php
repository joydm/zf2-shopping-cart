<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    public $register_message;
    public $login_message;

    public function indexAction()
    {

        $sm             = $this->getServiceLocator();
        $RegisterForm   = $sm->get('RegisterForm');
        $RegisterFilter = $sm->get('RegisterFilter');
        $LoginForm      = $sm->get('LoginForm');
        $Customer       = $sm->get('Customer');
        $CustomerTable  = $sm->get('CustomerTable');

        $request = $this->getRequest();
        $loginOrigin = ($this->params()->fromQuery('origin') != null) ? $this->params()->fromQuery('origin') : null;

        if ($request->isPost())
        {

            if($request->getPost()->action == "register")
            {

                $RegisterForm->setInputFilter($RegisterFilter);
                $RegisterForm->setData($request->getPost());

                if($RegisterForm->isValid())
                {

                    $Customer->exchangeArray($RegisterForm->getData());
                    $existingEmail = $CustomerTable->customerEmailExist($Customer);

                        if($existingEmail)
                        {
                            $this->register_message = "Email address already exist.";
                        }else
                        {
                            $this->register_message = "";
                            $this->processRegistration($Customer);
                        }
                }
            }else
            {
                $this->loginAction($loginOrigin);
            }
        }

        return new ViewModel(array(
            'register_form'     => $RegisterForm,
            'login_form'        => $LoginForm,
            'register_response' => $this->register_message,
            'login_response'    => $this->login_message,
        ));
    }

    public function loginAction($loginOrigin)
    {
        $request = $this->getRequest();

        $sm             = $this->getServiceLocator();
        $LoginForm      = $sm->get('LoginForm');
        $LoginFilter    = $sm->get('LoginFilter');
        $CustomerTable  = $sm->get('CustomerTable');

        $LoginForm->setInputFilter($LoginFilter);
        $LoginForm->setData($request->getPost());

        if($LoginForm->isValid())
        {

            $data = $LoginForm->getData();
            $customer = $CustomerTable->loginCustomer($data);

            if(!empty($customer)){

                $this->login_message = "";
                $this->buildCustomerSession($customer);

                if($loginOrigin == "cart")
                {
                    return $this->redirect()->toRoute('product', array('action' => 'shipping'));
                }else
                {
                    return $this->redirect()->toRoute('product');
                }

            }else
            {
                $this->login_message = "Account does not exist.";
            }
        }

    }

    public function processRegistration($data)
    {
        $sm             = $this->getServiceLocator();
        $CustomerTable  = $sm->get('CustomerTable');

        $newCustomerId = $CustomerTable->addCustomer($data);
        if($newCustomerId)
        {
            $customer = $CustomerTable->getCustomer($newCustomerId);
            $this->buildCustomerSession($customer);
            return $this->redirect()->toRoute('product');

        }else return $this->redirect()->toRoute('auth');
    }

    public function buildCustomerSession($customer)
    {

        $sm                     = $this->getServiceLocator();
        $Session                = $sm->get('Container');
        $Session->customer_id   = (!empty($customer->customer_id)) ? $customer->customer_id : null;
        $Session->first_name    = (!empty($customer->first_name)) ? $customer->first_name : null;
    }

    public function logoutAction()
    {
        session_destroy();
        return $this->redirect()->toRoute('product');
    }

}