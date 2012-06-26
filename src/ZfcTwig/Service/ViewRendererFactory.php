<?php

namespace ZfcTwig\Service;

use ZfcTwig\View\Renderer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Resolver\TemplatePathStack;

class ViewRendererFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['zfctwig'];

        $pathResolver = $serviceLocator->get('ViewTemplatePathStack');
        $pathResolver->setDefaultSuffix($config['suffix']);
        $resolver = $serviceLocator->get('ViewResolver');

        $renderer = new Renderer();
        $renderer->setEngine($serviceLocator->get('TwigEnvironment'));
        $renderer->setResolver($resolver);

        return $renderer;
    }
}

