<?php
namespace ZfcTwig\Twig\Helper;
use Zend\Mvc\InjectApplicationEventInterface,
    Zend\EventManager\EventManager,
    Zend\EventManager\EventManagerInterface,
    Zend\EventManager\Event,
    Zend\ServiceManager\ServiceLocatorInterface;

class Trigger
{
    /**
     * @var \Zend\EventManager\EventManager | null
     */
    protected $events = null;
    protected $serviceLocator;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Set the event manager instance used by this context
     * @param \Zend\EventManager\EventManagerInterface $events
     * @return Trigger
     */
    public function setEventManager(EventManagerInterface $events)
    {
        $this->events = $events;
        return $this;
    }

    /**
     * Retrieve the event manager
     * Lazy-loads an EventManager instance if none registered.
     * @return EventManagerInterface
     */
    public function events()
    {
        if (!$this->events instanceof EventManagerInterface) {
            $this->setEventManager(new EventManager(array(
                __CLASS__,
                get_called_class(),
                'extend'
            )));
            $sharedManager = $this->serviceLocator->get('SharedEventManager');
            $this->events->setSharedManager($sharedManager);
        }
        return $this->events;
    }

    /**
     * Triggers the specified event on the defined context and return a concateneted string with the results
     * @param string $eventName
     * @param mixed $target
     * @param array $argv
     * @return string
     */
    public function __invoke($eventName, $target, $argv)
    {
        //init the event with the target, params and name
        $event = new Event();
        $event->setTarget($target);
        $event->setParams($argv);
        $event->setName($eventName);
        $content = "";
        //trigger the event listeners
        $responses = $this->events()->trigger($eventName, $event);
        //merge all results and return the response
        foreach ($responses as $response) {
            $content .= $response;
        }
        return $content;
    }

}
