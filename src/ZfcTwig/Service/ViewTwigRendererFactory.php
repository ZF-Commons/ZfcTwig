<?php

namespace ZfcTwig\Service;

use ZfcTwig\View\Renderer\TwigRenderer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ViewTwigRendererFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $renderer = new TwigRenderer(
            $serviceLocator->get('ZfcTwigEnvironment'),
            $serviceLocator->get('ZfcTwigResolver')
        );

        $renderer->setHelperPluginManager($serviceLocator->get('ZfcTwigViewHelperManager'));

        return $renderer;
    }
}