<?php
return array(
    'zfctwig' => array(
        /**
         * Options that are passed directly to the Twig_Environment.
         */
        'environment' => array(),

        /**
         * Service manager alias or fully qualified domain name of extensions.
         */
        'extensions' => array(
            'zfctwig' => 'ZfcTwigExtension'
        ),

        /**
         * Service manager alias of any additional loaders to register with the chain. The default
         * loader is a Twig_Loader_Filesystem with a copy of the default paths loaded
         * in the MVC TreeStack.
         */
        'loaders' => array(
            'ZfcTwigDefaultLoader'
        ),

        /**
         * The suffix of Twig files. Technically, Twig can load *any* type of file
         * but the templates in ZF are suffix agnostic so we must specify the extension
         * that's expected here.
         */
        'suffix' => '.twig',

        /**
         * If set to true disables ZF's notion of parent/child layouts in favor of
         * Twig's inheritance model.
         */
        'disable_zf_model' => true
    ),

    /**
     * Register the view strategy with the view manager. This is required!
     */
    'view_manager' => array(
        'strategies' => array('ZfcTwigViewStrategy')
    )
);