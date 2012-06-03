<?php

namespace ZfcTwig\Service;

use ZfcTwig\View\Strategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ViewStrategyFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $renderer = $serviceLocator->get('TwigViewRenderer');
        $strategy = new Strategy($renderer);

        return $strategy;
    }
}
