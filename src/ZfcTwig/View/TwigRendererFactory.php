<?php

namespace ZfcTwig\View;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwigRendererFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TwigRenderer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \ZfcTwig\moduleOptions $options */
        $options = $serviceLocator->get('ZfcTwig\ModuleOptions');

        $renderer = new TwigRenderer(
            $serviceLocator->get('Zend\View\View'),
            $serviceLocator->get('Twig_Environment'),
            $serviceLocator->get('ZfcTwigResolver')
        );

        $renderer->setCanRenderTrees($options->getDisableZfmodel());
        $renderer->setHelperPluginManager($serviceLocator->get('ZfcTwigViewHelperManager'));

        return $renderer;
    }
}