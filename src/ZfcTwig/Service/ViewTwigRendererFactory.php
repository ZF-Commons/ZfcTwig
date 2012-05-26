<?php

namespace ZfcTwig\Service;

use ZfcTwig\View\Renderer\TwigRenderer;
use ZfcTwig\View\Resolver\TwigResolver;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Resolver\TemplatePathStack;

class ViewTwigRendererFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');

        $resolver = new TwigResolver();
        $resolver->setSuffix($config['zfctwig']['suffix']);

        $renderer = new TwigRenderer();
        $renderer->setEngine($serviceLocator->get('TwigEnvironment'));
        $renderer->setResolver($resolver);

        return $renderer;
    }
}

