<?php

namespace ZfcTwig\Service;

use Zend\Mvc\Service\ViewHelperManagerFactory as ParentViewHelperManagerFactory;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;
use Zend\View\HelperPluginManager;

/**
 * View Helper Manager Factory
 */
class ViewHelperManagerFactory extends ParentViewHelperManagerFactory
{
    /**
     * @var \Zend\Stdlib\Hydrator\Reflection
     */
    protected $hydrator;

    /**
     * The properties which should be copied from the ViewHelperManager
     * 
     * @var array
     */
    protected $properties = array(
        'invokableClasses',
        'factories',
        'abstractFactories',
        'aliases',
    );

    /**
     * @return Zend\Stdlib\Hydrator\Reflection
     */
    public function getHydrator()
    {
        if (null == $this->hydrator) {
            $this->hydrator = new ReflectionHydrator;
        }
        
        return $this->hydrator;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return HelperPluginManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydrator = $this->getHydrator();
        $viewHelperManager = parent::createService($serviceLocator);
        $copy = array();

        $data = $hydrator->extract($serviceLocator->get('ViewHelperManager'));
        foreach ($this->properties as $key) {
            $copy[$key] = $data[$key];
        }
        $hydrator->hydrate($copy, $viewHelperManager);
        return $viewHelperManager;
    }
}
