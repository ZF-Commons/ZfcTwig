<?php

namespace ZfcTwig\Twig;

use InvalidArgumentException;
use Twig_Loader_Chain;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ChainLoaderFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @throws \InvalidArgumentException
     * @return Twig_Loader_Chain
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \ZfcTwig\moduleOptions $options */
        $options = $serviceLocator->get('ZfcTwig\ModuleOptions');

        // Setup loader
        $chain = new Twig_Loader_Chain();

        foreach ($options->getLoaderChain() as $loader) {
            if (!is_string($loader) || !$serviceLocator->has($loader)) {
                throw new InvalidArgumentException('Loaders should be a service manager alias.');
            }
            $chain->addLoader($serviceLocator->get($loader));
        }

        return $chain;
    }
}