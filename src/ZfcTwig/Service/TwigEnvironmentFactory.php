<?php

namespace ZfcTwig\Service;

use RuntimeException;
use Twig_Environment;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcTwig\Twig\Func\ViewHelper;

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
        $env     = new Twig_Environment(null, (array) $config['environment_options']);

        if ($config['enable_fallback_functions']) {
            $helperPluginManager = $serviceLocator->get('ViewHelperManager');
            $env->registerUndefinedFunctionCallback(function($name) use ($helperPluginManager) {
                if ($helperPluginManager->has($name)) {
                    return new ViewHelper($name);
                }
                return false;
            });
        }

        if (!$serviceLocator->has($config['environment_loader'])) {
            throw new RuntimeException(sprintf(
                'Loader with alias "%s" could not be found!',
                $config['loader']
            ));
        }

        $env->setLoader($serviceLocator->get($config['environment_loader']));

        // Extensions are loaded later to avoid circular dependencies (for example, if an extension needs Renderer).
        return $env;
    }
}
