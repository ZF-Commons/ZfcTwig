<?php

namespace ZfcTwig\View;

use ZfcTwig\View\Renderer;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\ViewEvent;

class Strategy implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * @var \ZfcTwig\View\Renderer\Renderer
     */
    protected $renderer;

    /**
     * Constructor
     *
     * @param  \ZfcTwig\View\Renderer\Renderer $renderer
     * @return void
     */
    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param \Zend\EventManager\EventManagerInterface $events
     * @param integer $priority
     */
    public function attach(EventManagerInterface $events, $priority = 100)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }

    /**
     * @param \Zend\EventManager\EventManagerInterface $events
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    /**
     * @param \Zend\View\ViewEvent $e
     * @return \Zend\Feed\Writer\Renderer\RendererInterface|boolean
     */
    public function selectRenderer(ViewEvent $e)
    {
        if (!$this->renderer->canRender($e->getModel()->getTemplate())) {
            return false;
        }
        return $this->renderer;
    }

    /**
     * @param \Zend\View\ViewEvent $e
     * @return null
     */
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            return;
        }
        $result   = $e->getResult();
        $response = $e->getResponse();

        $response->setContent($result);
    }
}