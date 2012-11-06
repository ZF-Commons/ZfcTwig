<?php

namespace ZfcTwig\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcTwig\View\Resolver;

class ViewResolverFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \ZfcTwig\View\Resolver
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['zfctwig'];

        $pathResolver = clone $serviceLocator->get('ViewTemplatePathStack');
        $pathResolver->setDefaultSuffix($config['suffix']);

        $resolver = clone $serviceLocator->get('ViewResolver');
        $resolver->attach($pathResolver, 2);

        $loader = new Resolver(array());
        $loader->setFallbackResolver($resolver);

        foreach ($config['namespaces'] as $namespace => $path) {
            $loader->addPath($path, $namespace);
        }

        return $loader;
    }
}

