<?php

namespace ZfcTwig;

use Twig_Loader_Filesystem;
use Zend\Mvc\MvcEvent;
use ZfcTwig\View\InjectViewModelListener;
use ZfcTwig\View\Renderer\TwigRenderer;
use ZfcTwig\View\Resolver\TwigResolver;
use ZfcTwig\View\Strategy\TwigStrategy;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $application    = $e->getApplication();
        $serviceManager = $application->getServiceManager();

        /** @var $environment \ZfcTwig\Twig\Environment */
        $environment = $serviceManager->get('TwigEnvironment');
        if ($environment->getZfcTwigOptions()->getDisableZfModel()) {
            $events       = $application->getEventManager();
            $sharedEvents = $events->getSharedManager();
            $vmListener   = new InjectViewModelListener($environment);

            $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($vmListener, 'injectViewModel'), -99);
            $sharedEvents->attach('Zend\Stdlib\DispatchableInterface', MvcEvent::EVENT_DISPATCH, array($vmListener, 'injectViewModel'), -99);
        }
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'TwigEnvironment' => 'ZfcTwig\Service\TwigEnvironmentFactory',
                'TwigDefaultLoader' => 'ZfcTwig\Service\TwigDefaultLoaderFactory',
                'TwigRenderer' => function($sm) {
                    return new TwigRenderer($sm->get('TwigEnvironment'), $sm->get('TwigResolver'));
                },
                'TwigResolver' => function($sm) {
                    return new TwigResolver($sm->get('TwigEnvironment'));
                },
                'ViewTwigStrategy' => function($sm) {
                    $strategy = new TwigStrategy($sm->get('TwigRenderer'));
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