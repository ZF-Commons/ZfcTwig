<?php

namespace ZfcTwig\Service;

use InvalidArgumentException;
use ZfcTwig\Twig\Loader\AbsoluteFilesystem;
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
        $manager = $serviceLocator->get('ViewHelperManager');

        $loader = new AbsoluteFilesystem($config['paths']);
        $loader->setFallbackResolver($serviceLocator->get('ViewTemplatePathStack'));

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