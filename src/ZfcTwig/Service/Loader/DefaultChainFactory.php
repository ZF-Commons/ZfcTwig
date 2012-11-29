<?php

namespace ZfcTwig\Service\Loader;

use InvalidArgumentException;
use Twig_Loader_Chain;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DefaultChainFactory implements FactoryInterface
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

        // Setup loader
        $chain = new Twig_Loader_Chain();

        foreach((array) $config['loader_chain'] as $loader) {
            if (!is_string($loader) || !$serviceLocator->has($loader)) {
                throw new InvalidArgumentException('Loaders should be a service manager alias.');
            }
            $chain->addLoader($serviceLocator->get($loader));
        }

        return $chain;
    }
}