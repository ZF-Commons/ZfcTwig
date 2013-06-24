<?php

return array(
    'aliases' => array(
        'ZfcTwigExtension'               => 'ZfcTwig\Twig\ExtensionFactory',
        'ZfcTwigLoaderChain'             => 'ZfcTwig\Twig\ChainLoaderFactory',
        'ZfcTwigLoaderTemplateMap'       => 'ZfcTwig\Twig\MapLoaderFactory',
        'ZfcTwigLoaderTemplatePathStack' => 'ZfcTwig\Twig\StackLoaderFactory',
        'ZfcTwigRenderer'                => 'ZfcTwig\View\TwigRendererFactory',
        'ZfcTwigResolver'                => 'ZfcTwig\View\TwigResolverFactory',
        'ZfcTwigViewHelperManager'       => 'ZfcTwig\View\HelperPluginManagerFactory',
        'ZfcTwigViewStrategy'            => 'ZfcTwig\View\TwigStrategyFactory',
    ),

    'factories' => array(
        'ZfcTwigEnvironment'                      => 'ZfcTwig\Twig\EnvironmentFactory',

        'ZfcTwig\Twig\ExtensionFactory'           => 'ZfcTwig\Twig\ExtensionFactory',
        'ZfcTwig\Twig\ChainLoaderFactory'         => 'ZfcTwig\Twig\ChainLoaderFactory',
        'ZfcTwig\Twig\MapLoaderFactory'           => 'ZfcTwig\Twig\MapLoaderFactory',

        'ZfcTwig\Twig\StackLoaderFactory'         => 'ZfcTwig\Twig\StackLoaderFactory',
        'ZfcTwig\View\TwigRendererFactory'        => 'ZfcTwig\View\TwigRendererFactory',
        'ZfcTwig\View\TwigResolverFactory'        => 'ZfcTwig\View\TwigResolverFactory',
        'ZfcTwig\View\HelperPluginManagerFactory' => 'ZfcTwig\View\HelperPluginManagerFactory',
        'ZfcTwig\View\TwigStrategyFactory'        => 'ZfcTwig\View\TwigStrategyFactory',

        'ZfcTwig\ModuleOptions'                   => 'ZfcTwig\ModuleOptionsFactory'
    )
);
