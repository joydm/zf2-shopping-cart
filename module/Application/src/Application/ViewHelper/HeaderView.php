<?php
/**
 * Created by PhpStorm.
 * User: daren.d
 * Date: 5/4/2016
 * Time: 8:01 PM
 */

namespace Application\ViewHelper;
use Zend\View\Helper\AbstractHelper;

class HeaderView extends AbstractHelper
{
    public $Session;

    public function __construct($Session)
    {
        $this->Session = $Session;
    }

    public function __invoke($template)
    {
        $userLoggedIn = isset($this->Session->customer_id) ? true : false;
        $customerFirstName = $this->Session->first_name;

        $params = array(
            'userLoggedIn' => $userLoggedIn,
            'customerFirstName' => $customerFirstName,
        );

        return $this->getView()->render($template, $params);
    }

}