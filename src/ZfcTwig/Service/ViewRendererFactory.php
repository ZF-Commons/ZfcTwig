<?php

namespace ZfcTwig\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcTwig\View\Renderer;

/**
 * Twig View Renderer Factory
 */
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
        $renderer->setResolver($serviceLocator->get('TwigViewResolver'));

        return $renderer;
    }
}

