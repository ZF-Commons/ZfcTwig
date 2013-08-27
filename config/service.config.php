<?php

return array(
    'aliases' => array(
        'ZfcTwigExtension'               => 'ZfcTwig\Twig\Extension',
        'ZfcTwigLoaderChain'             => 'ZfcTwig\Twig\ChainLoader',
        'ZfcTwigLoaderTemplateMap'       => 'ZfcTwig\Twig\MapLoader',
        'ZfcTwigLoaderTemplatePathStack' => 'ZfcTwig\Twig\StackLoader',
        'ZfcTwigRenderer'                => 'ZfcTwig\View\TwigRenderer',
        'ZfcTwigResolver'                => 'ZfcTwig\View\TwigResolver',
        'ZfcTwigViewHelperManager'       => 'ZfcTwig\View\HelperPluginManager',
        'ZfcTwigViewStrategy'            => 'ZfcTwig\View\TwigStrategy',
    ),

    'factories' => array(
        'Twig_Environment' => 'ZfcTwig\Twig\EnvironmentFactory',

        'ZfcTwig\Twig\Extension'   => 'ZfcTwig\Twig\ExtensionFactory',
        'ZfcTwig\Twig\ChainLoader' => 'ZfcTwig\Twig\ChainLoaderFactory',
        'ZfcTwig\Twig\MapLoader'   => 'ZfcTwig\Twig\MapLoaderFactory',

        'ZfcTwig\Twig\StackLoader'         => 'ZfcTwig\Twig\StackLoaderFactory',
        'ZfcTwig\View\TwigRenderer'        => 'ZfcTwig\View\TwigRendererFactory',
        'ZfcTwig\View\TwigResolver'        => 'ZfcTwig\View\TwigResolverFactory',
        'ZfcTwig\View\HelperPluginManager' => 'ZfcTwig\View\HelperPluginManagerFactory',
        'ZfcTwig\View\TwigStrategy'        => 'ZfcTwig\View\TwigStrategyFactory',

        'ZfcTwig\ModuleOptions' => 'ZfcTwig\ModuleOptionsFactory'
    )
);
