<?php

namespace ZfcTwig\Service;

use InvalidArgumentException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcTwig\Twig\Environment;
use ZfcTwig\Twig\Extension;

/**
 * Twig Environment Factory
 */
class EnvironmentFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \ZfcTwig\Twig\Environment
     * @throws InvalidArgumentException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['zfctwig'];

        $loader = $serviceLocator->get('TwigViewResolver');
        $twig = new Environment($loader, $config['config']);
        $twig->addExtension(new Extension($twig, $serviceLocator));

        $manager = $serviceLocator->get('TwigViewHelperManager');
        $twig->setManager($manager);

        foreach($config['extensions'] as $ext) {
            if (!is_string($ext)) {
                throw new InvalidArgumentException('Extension name must be a string');
            }
            $twig->addExtension(new $ext);
        }

        return $twig;
    }
}