<?php
return array(
    'zfctwig' => array(
        'environment' => array(
        ),

        'extensions' => array(
            'zfctwig' => 'ZfcTwigExtension'
        ),

        'loaders' => array(
            'ZfcTwigDefaultLoader'
        ),

        'suffix' => '.twig',

        'disable_zf_model' => true
    ),

    'view_manager' => array(
        'strategies' => array('ZfcTwigViewStrategy')
    )
);