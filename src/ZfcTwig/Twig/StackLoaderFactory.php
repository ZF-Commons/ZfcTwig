<?php

namespace ZfcTwig\Twig;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StackLoaderFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \ZfcTwig\moduleOptions $options */
        $options = $serviceLocator->get('ZfcTwig\ModuleOptions');

        /** @var $templateStack \Zend\View\Resolver\TemplatePathStack */
        $zfTemplateStack = $serviceLocator->get('ViewTemplatePathStack');

        $templateStack = new StackLoader($zfTemplateStack->getPaths()->toArray());
        $templateStack->setDefaultSuffix($options->getSuffix());

        return $templateStack;
    }
}
