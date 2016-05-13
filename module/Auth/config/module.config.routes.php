<?php

return array(

    'router' => array(
        'routes' => array(

            'auth' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/auth[/:action]',

                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),

                    'defaults' => array(
                        'controller' => 'Auth\Controller\Auth',
                        'action'     => 'index',


                    ),
                ),
            ),
        ),
    ),
);