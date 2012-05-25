<?php

namespace SpiffyTwig\Service;

use Twig_Environment;
use Twig_Loader_Filesystem;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwigFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');

        $loader = new Twig_Loader_Filesystem($config['view_manager']['template_path_stack']);
        $twig   = new Twig_Environment($loader, array(
            'cache' => $config['spiffytwig']['cache']
        ));
        return $twig;
    }
}