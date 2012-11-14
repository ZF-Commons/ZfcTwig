<?php

namespace ZfcTwig;

use InvalidArgumentException;
use Zend\Mvc\MvcEvent;
use ZfcTwig\Twig\Extension\ZfcTwig as ZfcTwigExtension;
use ZfcTwig\View\InjectViewModelListener;
use ZfcTwig\View\Resolver\TwigResolver;
use ZfcTwig\View\Strategy\TwigStrategy;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $application    = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $environment    = $serviceManager->get('ZfcTwigEnvironment');

        $config = $serviceManager->get('Configuration');
        $config = $config['zfctwig'];

        // Setup extensions
        foreach((array) $config['extensions'] as $extension) {
            if (is_string($extension)) {
                if ($serviceManager->has($extension)) {
                    $extension = $serviceManager->get($extension);
                } else {
                    $extension = new $extension();
                }
            } else if (!is_object($extension)) {
                throw new InvalidArgumentException('Extensions should be a string or object.');
            }

            $environment->addExtension($extension);
        }

        if ($config['disable_zf_model']) {
            $events       = $application->getEventManager();
            $sharedEvents = $events->getSharedManager();
            $vmListener   = new InjectViewModelListener($serviceManager->get('ZfcTwigRenderer'));

            $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($vmListener, 'injectViewModel'), -99);
            $sharedEvents->attach('Zend\Stdlib\DispatchableInterface', MvcEvent::EVENT_DISPATCH, array($vmListener, 'injectViewModel'), -99);
        }
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'ZfcTwigEnvironment' => 'ZfcTwig\Service\TwigEnvironmentFactory',
                'ZfcTwigExtension' => function($sm) {
                    return new ZfcTwigExtension($sm->get('ZfcTwigRenderer'));
                },
                'ZfcTwigLoaderChain' => 'ZfcTwig\Service\Loader\DefaultChainFactory',
                'ZfcTwigLoaderTemplateMap' => 'ZfcTwig\Service\Loader\TemplateMapFactory',
                'ZfcTwigLoaderTemplatePathStack' => 'ZfcTwig\Service\Loader\TemplatePathStackFactory',
                'ZfcTwigRenderer' => 'ZfcTwig\Service\ViewTwigRendererFactory',
                'ZfcTwigResolver' => function($sm) {
                    return new TwigResolver($sm->get('ZfcTwigEnvironment'));
                },
                'ZfcTwigViewHelperManager' => function($sm) {
                    // Clone the ViewHelperManager because each plugin has its own view instance.
                    // If we don't clone it then the ViewHelpers use PhpRenderer.
                    // This should really be changed in ZF Proper to call the event to determine which Renderer to use.
                    //return clone $sm->get('ViewHelperManager');
                    return $sm->get('ViewHelperManager');
                },
                'ZfcTwigViewStrategy' => function($sm) {
                    $strategy = new TwigStrategy($sm->get('ZfcTwigRenderer'));
                    return $strategy;
                }
            )
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
}