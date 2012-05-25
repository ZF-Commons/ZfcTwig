<?php

namespace ZfcTwig\Service;

use ZfcTwig\Twig\Environment;
use Twig_Loader_Filesystem;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwigFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $broker = $serviceLocator->get('ViewHelperBroker');

        $loader = new Twig_Loader_Filesystem($config['view_manager']['template_path_stack']);
        $twig   = new Environment($loader, array(
            //'cache' => $config['ZfcTwig']['cache']
        ));

        $twig->setBroker($broker);
        return $twig;
    }
}