<?php

return array(

    'view_manager' => array(
        'layout' => 'layout/layout',

        'template_path_stack' => array(
            'auth' =>   __DIR__ . '/../view',
        ),

        'template_map' => array(
            'layout/layout'     => __DIR__ . '/../view/layout/layout.phtml',
            'register_form'     => __DIR__ . '/../view/auth/auth/register.phtml',
            'login_form'        => __DIR__ . '/../view/auth/auth/login.phtml',
        )
    ),


);