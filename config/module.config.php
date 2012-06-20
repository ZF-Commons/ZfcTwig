<?php
return array(
    'zfctwig' => array(
        'config' => array(
            'cache' => 'data/cache/twig',
            'allow_php_fallback' => true,
            'auto_reload'=>true,
        ),
        'suffix' => '.twig',
        'extensions' => array(

        )
    ),
    'view_manager' => array(
        'strategies'   => array('TwigViewStrategy'),
        'template_map' => array(
            'index/index' => __DIR__ . '/../view/index/index.twig',
            'error/404'   => __DIR__ . '/../view/error/404.twig',
            'error/index' => __DIR__ . '/../view/error/index.twig',
        ),
    )
);