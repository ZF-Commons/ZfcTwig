<?php

namespace ZfcTwig\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcTwig\Twig\Extension\ZfcTwig as ZfcTwigExtension;

class TwigExtensionFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ZfcTwigExtension($serviceLocator->get('ZfcTwigViewHelperManager'));
    }
}