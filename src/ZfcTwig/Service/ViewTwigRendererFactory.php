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
        $config = $serviceLocator->get('Configuration');
        $config = $config['zfctwig'];

        $renderer = new TwigRenderer(
            $serviceLocator->get('Zend\View\View'),
            $serviceLocator->get('ZfcTwigEnvironment'),
            $serviceLocator->get('ZfcTwigResolver')
        );

        $renderer->setCanRenderTrees($config['disable_zf_model']);
        $renderer->setHelperPluginManager($serviceLocator->get('ZfcTwigViewHelperManager'));

        return $renderer;
    }
}