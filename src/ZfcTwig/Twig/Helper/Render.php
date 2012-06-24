<?php
namespace ZfcTwig\Twig\Helper;
use Zend\Http\Response,
    Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ModelInterface,
    Zend\View\Model\ViewModel,
    Zend\Mvc\InjectApplicationEventInterface,
    Zend\EventManager\EventManager,
    Zend\EventManager\EventManagerInterface,
    Zend\EventManager\Event,
    Zend\ServiceManager\ServiceLocatorInterface;

class Render
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
     * @return Extension
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
        }
        return $this->events;
    }

    /**
     * Run an action from the specified controller and render it's associated template or view model
     * @param string $expr
     * @param array $attributes
     * @param array $options
     * @return string
     */
    public function __invoke($expr, $attributes, $options)
    {
        $serviceManager = $this->serviceLocator;
        $application = $serviceManager->get('Application');
        //parse the name of the controller, action and template directory that should be used
        $params = explode('/', $expr);
        $controllerName = $params[0];
        $actionName = $params[1];
        $templateDir = $controllerName . '/';

        //instantiate the controller based on the given name
        $controller = $serviceManager->get('ControllerLoader')->get($controllerName);
        //clone the MvcEvent and route and update them with the provided parameters
        $event = $application->getMvcEvent();
        $routeMatch = clone $event->getRouteMatch();
        $event = clone $event;
        foreach ($attributes as $key => $value) {
            $routeMatch->setParam($key, $value);
        }
        $event->setRouteMatch($routeMatch);

        //inject the new event into the controller
        if ($controller instanceof InjectApplicationEventInterface) {
            $controller->setEvent($event);
        }

        //test if the action exists in the controller and change it to not-found if missing
        $method = ActionController::getMethodFromAction($actionName);
        if (!method_exists($controller, $method)) {
            $method = 'notFoundAction';
            $actionName = 'not-found';
        }
        //call the method on the controller
        $response = $controller->$method();
        //if the result is an instance of the Response class return it
        if ($response instanceof Response) {
            return $response->getBody();
        }

        //if the response is an instance of ViewModel then render that one
        if ($response instanceof ModelInterface) {
            $viewModel = $response;
        } elseif ($response === null || is_array($response) || $response instanceof \ArrayAccess || $response instanceof \Traversable) {
            $viewModel = new ViewModel($response);
            $viewModel->setTemplate($templateDir . $actionName);
        } else {
            return '';
        }
        $viewModel->terminate();
        $viewModel->setOption('has_parent', true);

        $view = $serviceManager->get('Zend\View\View');
        $output = $view->render($viewModel);
        return $output;
    }
}
