<?php
return array(
    'zfctwig' => array(
        'cache' => 'data/cache'
    ),
    'view_manager' => array(
        'strategies'   => array('ViewTwigStrategy'),
        'template_map' => array(
            'index/index'   => __DIR__ . '/../view/index/index.twig',
            'error/404'     => __DIR__ . '/../view/error/404.twig',
            'error/index'   => __DIR__ . '/../view/error/index.twig',
        ),
    )
);