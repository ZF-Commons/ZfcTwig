<?php

namespace ZfcTwig\Service;

use InvalidArgumentException;
use ZfcTwig\Twig\Loader\Filesystem;
use ZfcTwig\Twig\Environment;
use ZfcTwig\Twig\Extension;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EnvironmentFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['zfctwig'];
        $manager = clone $serviceLocator->get('ViewHelperManager');

        $loader = new Filesystem(array());
        $resolver = $serviceLocator->get('ViewResolver');
        $loader->setFallbackResolver($resolver);
        
        foreach ($config['namespaces'] as $namespace => $path) {
            $loader->addPath($path, $namespace);
        }

        $twig = new Environment($loader, $config['config']);
        $twig->addExtension(new Extension($twig, $serviceLocator));
        $twig->setManager($manager);

        foreach($config['extensions'] as $ext) {
            if (!is_string($ext)) {
                throw new InvalidArgumentException('Extension name must be a string');
            }
            $twig->addExtension(new $ext);
        }


        return $twig;
    }
}