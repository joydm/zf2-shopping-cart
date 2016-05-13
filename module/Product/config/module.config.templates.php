<?php

    return array(

        'view_manager' => array(
            'layout' => 'MAIN_LAYOUT',

            'template_path_stack' => array(
                'product' =>   __DIR__ . '/../view',
            ),

            'template_map' => array(
                'MAIN_LAYOUT'  => __DIR__ . '/../view/layout/layout.phtml', //layout for all actions
            )
        ),
        
        
    );