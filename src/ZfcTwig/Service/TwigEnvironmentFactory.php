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

        // Setup loader
        $loaderChain = new Twig_Loader_Chain();

        foreach((array) $config['loaders'] as $loader) {
            if (!is_string($loader) || !$serviceLocator->has($loader)) {
                throw new InvalidArgumentException('Loaders should be a service manager alias.');
            }
            $loaderChain->addLoader($serviceLocator->get($loader));
        }

        $env->setLoader($loaderChain);

        // Extensions are loaded later to avoid circular dependencies (for example, if an extension needs Renderer).

        return $env;
    }
}