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
        $loader        = new Twig_Loader_Filesystem('module/Application/view');

        foreach($templateStack->getPaths() as $path) {
            if (file_exists($path)) {
                $loader->addPath($path);
            }
        }

        return $loader;
    }
}