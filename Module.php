<?php

namespace ZfcTwig;

use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected static $serviceManager;

    public function onBootstrap(MvcEvent $event)
    {
        // Set the static service manager instance so we can use it everywhere in the module
        static::$serviceManager = $event->getApplication()->getServiceManager();
    }

    /**
     * Return the ServiceManager instance
     * @static
     * @return \Zend\ServiceManager\ServiceManager
     */
    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

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
                'TwigEnvironment'  => 'ZfcTwig\Service\EnvironmentFactory',
                'TwigViewRenderer' => 'ZfcTwig\Service\ViewRendererFactory',
                'TwigViewStrategy' => 'ZfcTwig\Service\ViewStrategyFactory',
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

}