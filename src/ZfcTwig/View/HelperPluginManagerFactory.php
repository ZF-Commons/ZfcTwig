<?php

namespace ZfcTwig\View;

use Zend\ServiceManager\Config;
use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Exception;

class HelperPluginManagerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @throws \Zend\View\Exception\RuntimeException
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \ZfcTwig\moduleOptions $options */
        $options        = $serviceLocator->get('ZfcTwig\ModuleOptions');
        $managerOptions = $options->getHelperManager();
        $managerConfigs = isset($managerOptions['configs']) ? $managerOptions['configs'] : array();

        $baseManager = $serviceLocator->get('ViewHelperManager');
        $twigManager = new HelperPluginManager(new Config($managerOptions));
        $twigManager->addPeeringServiceManager($baseManager);

        foreach ($managerConfigs as $configClass) {
            if (is_string($configClass) && class_exists($configClass)) {
                $config = new $configClass;

                if (!$config instanceof ConfigInterface) {
                    throw new Exception\RuntimeException(
                        sprintf(
                            'Invalid service manager configuration class provided; received "%s",
                                expected class implementing %s',
                            $configClass,
                            'Zend\ServiceManager\ConfigInterface'
                        )
                    );
                }

                $config->configureServiceManager($twigManager);
            }
        }

        return $twigManager;
    }
}