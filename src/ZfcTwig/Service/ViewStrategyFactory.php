<?php

namespace ZfcTwig\Service;

use ZfcTwig\View\Strategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * View Strategy Factory
 */
class ViewStrategyFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \ZfcTwig\View\Strategy
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $renderer = $serviceLocator->get('TwigViewRenderer');
        return new Strategy($renderer);
    }
}
