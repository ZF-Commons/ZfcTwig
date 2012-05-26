<?php

namespace ZfcTwig;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfiguration()
    {
        return array(
            'aliases' => array(),
            'factories' => array(
                'TwigEnvironment'  => 'ZfcTwig\Service\TwigEnvironmentFactory',
                'ViewTwigStrategy' => 'ZfcTwig\Service\ViewTwigStrategyFactory',
                'ViewTwigRenderer' => 'ZfcTwig\Service\ViewTwigRendererFactory'
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}