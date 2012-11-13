<?php

namespace ZfcTwig\Service;

use InvalidArgumentException;
use Twig_Environment;
use Twig_Loader_Chain;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwigEnvironmentFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config  = $serviceLocator->get('Configuration');
        $config  = $config['zfctwig'];
        $env     = new Twig_Environment(null, (array) $config['environment']);

        // Setup extensions
        foreach((array) $config['extensions'] as $extension) {
            if (is_string($extension)) {
                if ($serviceLocator->has($extension)) {
                    $extension = $serviceLocator->get($extension);
                } else {
                    $extension = new $extension();
                }
            } else if (!is_object($extension)) {
                throw new InvalidArgumentException('Extensions should be a string or object.');
            }

            $env->addExtension($extension);
        }

        // Setup loader
        $loaderChain = new Twig_Loader_Chain();

        foreach((array) $config['loaders'] as $loader) {
            if (!is_string($loader) || !$serviceLocator->has($loader)) {
                throw new InvalidArgumentException('Loaders should be a service manager alias.');
            }
            $loaderChain->addLoader($serviceLocator->get($loader));
        }

        $env->setLoader($loaderChain);

        return $env;
    }
}