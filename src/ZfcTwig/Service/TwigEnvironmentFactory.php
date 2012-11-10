<?php

namespace ZfcTwig\Service;

use InvalidArgumentException;
use Twig_Loader_Chain;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcTwig\Twig\Environment;
use ZfcTwig\Twig\Fnction\ViewHelper;
use ZfcTwig\Options\TwigEnvironment as TwigEnvironmentOptions;

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

        /** @var $helperManager \Zend\View\HelperPluginManager */
        $helperManager = $serviceLocator->get('ViewHelperManager');

        $options = new TwigEnvironmentOptions($config);
        $env     = new Environment(null, $options->getEnvironment());

        $env->setHelperPluginManager($helperManager);

        // Setup extensions
        foreach($options->getExtensions() as $extension) {
            if (is_string($extension)) {
                if ($serviceLocator->has($extension)) {
                    $extension = $serviceLocator->get($extension);
                } else {
                    $extension = new $extension;
                }
            } else if (!is_object($extension)) {
                throw new InvalidArgumentException('Extensions should be a string or object.');
            }

            $env->addExtension($extension);
        }

        // Setup loader
        $loaderChain = new Twig_Loader_Chain();

        foreach($options->getLoaders() as $loader) {
            if (!is_string($loader) || !$serviceLocator->has($loader)) {
                throw new InvalidArgumentException('Loaders should be a service manager alias.');
            }
            $loaderChain->addLoader($serviceLocator->get($loader));
        }

        $env->setLoader($loaderChain);
        $env->registerUndefinedFunctionCallback(function($name) use ($helperManager) {
            if ($helperManager->has($name)) {
                return new ViewHelper($name);
            }
            return null;
        });

        $env->setDefaultSuffix($options->getSuffix());
        return $env;
    }
}