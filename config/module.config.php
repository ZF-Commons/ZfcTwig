<?php
return array(
    'zfctwig' => array(
        'config' => array(
            //'cache' => 'data/cache'
        ),
        'suffix' => '.twig',
    ),
    'view_manager' => array(
        'strategies'   => array('ViewTwigStrategy'),
        'template_map' => array(
            'index/index' => __DIR__ . '/../view/index/index.twig',
            'error/404'   => __DIR__ . '/../view/error/404.twig',
            'error/index' => __DIR__ . '/../view/error/index.twig',
        ),
    )
);