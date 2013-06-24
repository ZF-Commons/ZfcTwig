<?php

namespace ZfcTwig;

use InvalidArgumentException;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements
    BootstrapListenerInterface,
    ConfigProviderInterface
{
    public function onBootstrap(EventInterface $e)
    {
        /** @var \Zend\Mvc\MvcEvent $e*/
        $application    = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $environment    = $serviceManager->get('ZfcTwigEnvironment');

        /** @var \ZfcTwig\moduleOptions $options */
        $options = $serviceManager->get('ZfcTwig\ModuleOptions');

        // Setup extensions
        foreach ($options->getExtensions() as $extension) {
            if (is_string($extension)) {
                if ($serviceManager->has($extension)) {
                    $extension = $serviceManager->get($extension);
                } else {
                    $extension = new $extension();
                }
            } elseif (!is_object($extension)) {
                throw new InvalidArgumentException('Extensions should be a string or object.');
            }

            $environment->addExtension($extension);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
}
