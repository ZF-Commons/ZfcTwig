<?php

namespace ZfcTwig\Service;

use Zend\Mvc\Service\ViewHelperManagerFactory as ParentViewHelperManagerFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * View Helper Manager Factory
 */
class ViewHelperManagerFactory extends ParentViewHelperManagerFactory
{
    const PLUGIN_MANAGER_CLASS = 'ZfcTwig\View\HelperPluginManager';

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Zend\View\HelperPluginManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $viewHelperManager = parent::createService($serviceLocator);
        $viewHelperManager->addPeeringServiceManager($serviceLocator->get('ViewHelperManager'));
        return $viewHelperManager;
    }
}
