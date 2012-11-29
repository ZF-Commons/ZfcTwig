<?php

namespace ZfcTwig\Service\Loader;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcTwig\Twig\Loader\TemplateMap;

class TemplateMapFactory implements FactoryInterface
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

        /** @var \Zend\View\Resolver\TemplateMapResolver */
        $zfTemplateMap = $serviceLocator->get('ViewTemplateMapResolver');

        $templateMap = new TemplateMap();
        foreach($zfTemplateMap as $name => $path) {
            if ($config['suffix'] == pathinfo($path, PATHINFO_EXTENSION)) {
                $templateMap->add($name, $path);
            }
        }

        return $templateMap;
    }
}