<?php

namespace ZfcTwig;

use Zend\Mvc\MvcEvent;
use ZfcTwig\View\InjectViewModelListener;
use ZfcTwig\View\Resolver\TwigResolver;
use ZfcTwig\View\Strategy\TwigStrategy;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $application    = $e->getApplication();
        $serviceManager = $application->getServiceManager();

        $config = $serviceManager->get('Configuration');
        $config = $config['zfctwig'];

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
                'ZfcTwigExtension' => 'ZfcTwig\Service\TwigExtensionFactory',
                'ZfcTwigDefaultLoader' => 'ZfcTwig\Service\TwigDefaultLoaderFactory',
                'ZfcTwigRenderer' => 'ZfcTwig\Service\TwigRendererFactory',
                'ZfcTwigResolver' => function($sm) {
                    return new TwigResolver($sm->get('ZfcTwigEnvironment'));
                },
                'ZfcTwigViewHelperManager' => function($sm) {
                    // Clone the ViewHelperManager because each plugin has its own view instance.
                    // If we don't clone it then the ViewHelpers use PhpRenderer.
                    // This should really be changed in ZF Proper to call the event to determine which Renderer to use.
                    return clone $sm->get('ViewHelperManager');
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
        return include __DIR__ . '/config/module.config.php';
    }
}