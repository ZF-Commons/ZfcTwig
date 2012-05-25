<?php

namespace ZfcTwig\Service;

use ZfcTwig\View\Strategy\TwigStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ViewTwigStrategyFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $twigRenderer = $serviceLocator->get('ViewTwigRenderer');
        $twigStrategy = new TwigStrategy($twigRenderer);
        return $twigStrategy;
    }
}
