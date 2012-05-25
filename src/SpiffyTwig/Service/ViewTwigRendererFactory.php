<?php

namespace SpiffyTwig\Service;

use SpiffyTwig\View\Renderer\TwigRenderer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ViewTwigRendererFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Clone the default TemplateStack, change the suffix, and assign to TwigRenderer.
        // @todo probably a better way to do this
        $twigStack    = clone $serviceLocator->get('ViewTemplatePathStack');
        $twigStack->setDefaultSuffix('.twig');

        $twig = $serviceLocator->get('Twig');

        $twigRenderer = new TwigRenderer();
        $twigRenderer->setResolver($twigStack);
        $twigRenderer->setEngine($twig);
        return $twigRenderer;
    }
}

