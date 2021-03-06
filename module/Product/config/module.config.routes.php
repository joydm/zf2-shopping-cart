<?php

    return array(

        'router' => array(
            'routes' => array(

                'product' => array(
                    'type'    => 'segment',
                    'options' => array(
                        'route'    => '/product[/:action][/:id]',

                        'constraints' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+',
                        ),

                        'defaults' => array(
                            'controller' => 'Product\Controller\Product',
                            'action'     => 'index',
                        ),
                    ),
                ),
            ),
        ),
    );