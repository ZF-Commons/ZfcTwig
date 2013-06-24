<?php

namespace ZfcTwig\Twig;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MapLoaderFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \ZfcTwig\moduleOptions $options */
        $options = $serviceLocator->get('ZfcTwig\ModuleOptions');

        /** @var \Zend\View\Resolver\TemplateMapResolver */
        $zfTemplateMap = $serviceLocator->get('ViewTemplateMapResolver');

        $templateMap = new MapLoader();
        foreach ($zfTemplateMap as $name => $path) {
            if ($options->getSuffix() == pathinfo($path, PATHINFO_EXTENSION)) {
                $templateMap->add($name, $path);
            }
        }

        return $templateMap;
    }
}