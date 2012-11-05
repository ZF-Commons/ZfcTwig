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

        $renderer = new Renderer();
        $renderer->setSuffixLocked(isset($config['suffix_locked']) ? $config['suffix_locked'] : false);
        $renderer->setSuffix(isset($config['suffix']) ? $config['suffix'] : 'twig');

        $engine = $serviceLocator->get('TwigEnvironment');
        $renderer->setHelperPluginManager($engine->manager());
        $renderer->setEngine($engine);
        $renderer->setResolver($serviceLocator->get('TwigResolver'));

        return $renderer;
    }
}

