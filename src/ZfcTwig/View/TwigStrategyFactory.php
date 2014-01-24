<?php

namespace ZfcTwig\View;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwigStrategyFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TwigStrategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new TwigStrategy($serviceLocator->get('ZfcTwigRenderer'));
    }
}
