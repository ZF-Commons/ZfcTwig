<?php
return array(
    'zfctwig' => array(
        'config' => array(
            'cache' => 'data/cache/twig',
            'allow_php_fallback' => true,
            'auto_reload' => true,
        ),
        'suffix' => 'twig',
        'suffix_locked' => true,
        'extensions' => array(

        ),
        'namespaces' => array(
            
        ),
    ),
    'view_manager' => array(
        'strategies'   => array('TwigViewStrategy'),
        'template_map' => array(),
    )
);