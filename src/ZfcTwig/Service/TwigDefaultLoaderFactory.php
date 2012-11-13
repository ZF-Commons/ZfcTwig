<?php

namespace ZfcTwig\Service;

use Twig_Loader_Chain;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcTwig\Twig\Loader\TemplateMap;
use ZfcTwig\Twig\Loader\TemplatePathStack;

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
        $config        = $serviceLocator->get('Configuration');
        $config        = $config['zfctwig'];

        $chain       = new Twig_Loader_Chain();
        $filesystem  = new TemplatePathStack($templateStack->getPaths()->toArray());
        $templateMap = new TemplateMap();

        /** @var \Zend\View\Resolver\TemplateMapResolver */
        $zfTemplateMap = $serviceLocator->get('ViewTemplateMapResolver');

        foreach($zfTemplateMap as $name => $path) {
            if ($config['suffix'] == pathinfo($path, PATHINFO_EXTENSION)) {
                $templateMap->add($name, $path);
            }
        }

        $chain->addLoader($filesystem);
        $chain->addLoader($templateMap);

        return $chain;
    }
}