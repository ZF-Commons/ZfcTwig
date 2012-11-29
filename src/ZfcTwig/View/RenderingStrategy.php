<?php

namespace ZfcTwig\View;

use Twig_Environment;
use Twig_Error_Loader;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

/**
 * @category   Zend
 * @package    Zend_Mvc
 * @subpackage View
 */
class RenderingStrategy implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * @var Twig_Environment
     */
    protected $environment;

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, array($this, 'render'), -999);
    }

    /**
     * Detach all previously attached listeners
     *
     * @param EventManagerInterface $events
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * @param Twig_Environment $environment
     * @return RenderingStrategy
     */
    public function setEnvironment(Twig_Environment $environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return Twig_Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Render the view
     *
     * @param  MvcEvent $e
     * @return null|Response
     */
    public function render(MvcEvent $e)
    {
        $result = $e->getResult();
        if ($result instanceof Response) {
            return $result;
        }

        // Martial arguments
        $response  = $e->getResponse();
        $viewModel = $e->getViewModel();
        if (!$viewModel instanceof ViewModel) {
            return null;
        }

        try {
            $result = $this->getEnvironment()->render(
                $viewModel->getTemplate() . $this->getSuffix(),
                (array) $viewModel->getVariables()
            );
        } catch (Twig_Error_Loader $e) {
            return null;
        }

        $response->setContent($result);
        $e->setResult($response);

        return $response;
    }
}