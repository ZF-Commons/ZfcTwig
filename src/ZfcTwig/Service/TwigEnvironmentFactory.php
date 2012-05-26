<?php

namespace ZfcTwig\Service;

use ZfcTwig\Twig\Loader\AbsoluteFilesystem;
use ZfcTwig\Twig\Environment;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwigEnvironmentFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $broker = $serviceLocator->get('ViewHelperBroker');

        $loader = new AbsoluteFilesystem($config['zfctwig']['paths']);
        $loader->setFallbackResolver($serviceLocator->get('ViewTemplatePathStack'));

        $twig = new Environment($loader, $config['zfctwig']['config']);
        $twig->setBroker($broker);

        return $twig;
    }
}