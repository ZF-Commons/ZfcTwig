<?php

namespace ZfcTwig\Service;

use Twig_Loader_Filesystem;
use ZfcTwig\Twig\Environment;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwigEnvironmentFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $broker = $serviceLocator->get('ViewHelperBroker');
        $loader = new Twig_Loader_Filesystem($config['zfctwig']['paths']);

        $twig = new Environment($loader, $config['zfctwig']['config']);
        $twig->setBroker($broker);

        return $twig;
    }
}