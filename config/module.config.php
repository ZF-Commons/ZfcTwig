<?php
return array(
    'zfctwig' => array(
        'environment' => array(

        ),

        'extensions' => array(
            'zfctwig' => 'ZfcTwig\Twig\Extension'
        ),

        'loaders' => array(
            'TwigDefaultLoader'
        ),

        'disable_zf_model' => false,
    ),

    'view_manager' => array(
        'strategies' => array('ViewTwigStrategy')
    )
);