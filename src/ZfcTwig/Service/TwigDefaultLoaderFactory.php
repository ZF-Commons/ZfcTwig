<?php

namespace ZfcTwig\Service;

use Zend\ServiceManager\FactoryInterface;
use Twig_Loader_Filesystem;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwigDefaultLoaderFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $templateStack \Zend\View\Resolver\TemplatePathStack */
        $templateStack = $serviceLocator->get('ViewTemplatePathStack');
        $loader        = new Twig_Loader_Filesystem($templateStack->getPaths()->toArray());

        /** @var \Zend\View\Resolver\TemplateMapResolver */
        $templateMap = $serviceLocator->get('ViewTemplateMapResolver');
        $config      = $serviceLocator->get('Configuration');
        $config      = $config['zfctwig'];

        foreach($templateMap as $file) {
            if ($config['suffix'] == pathinfo($file, PATHINFO_EXTENSION)) {
                $loader->addPath(dirname($file));
            }
        }

        return $loader;
    }
}