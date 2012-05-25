<?php

namespace SpiffyTwig\View\Strategy;

use SpiffyTwig\View\Renderer\TwigRenderer;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\View\ViewEvent;

class TwigStrategy implements ListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * @var \SpiffyTwig\View\Renderer\TwigRenderer
     */
    protected $renderer;

    /**
     * Constructor
     *
     * @param  \SpiffyTwig\View\Renderer\TwigRenderer $renderer
     * @return void
     */
    public function __construct(TwigRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function attach(EventManagerInterface $events, $priority = 10)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, array($this, 'selectRenderer'), $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, array($this, 'injectResponse'), $priority);
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            $events->detach($listener);
            unset($this->listeners[$index]);
        }
    }

    public function selectRenderer(ViewEvent $e)
    {
        return $this->renderer;
    }

    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            return;
        }
        $result   = $e->getResult();
        $response = $e->getResponse();

        // Set content
        // If content is empty, check common placeholders to determine if they are
        // populated, and set the content from them.
        /*if (empty($result)) {
            $placeholders = $renderer->plugin('placeholder');
            $registry     = $placeholders->getRegistry();
            foreach ($this->contentPlaceholders as $placeholder) {
                if ($registry->containerExists($placeholder)) {
                    $result = (string) $registry->getContainer($placeholder);
                    break;
                }
            }
        }*/
        $response->setContent($result);
    }
}