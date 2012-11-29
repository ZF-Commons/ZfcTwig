<?php

namespace ZfcTwig\View;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\View\Http\InjectViewModelListener as ParentListener;
use Zend\View\Model\ViewModel;
use ZfcTwig\View\Renderer\TwigRenderer;

class InjectViewModelListener extends ParentListener
{
    /**
     * @var TwigRenderer
     */
    protected $renderer;

    /**
     * @param TwigRenderer $renderer
     */
    public function __construct(TwigRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * The child/parent model doesn't work well with Twig which already includes
     * its own inheritance model so we set the view model to the primary one.
     *
     * Children will *not* work with this module!
     *
     * @param  MvcEvent $e
     * @return void
     */
    public function injectViewModel(MvcEvent $e)
    {
        $result = $e->getResult();
        if (!$result instanceof ViewModel) {
            return;
        }

        // If we can render then replace view model with current.
        // This eliminates the inheritance model of ZF2.
        if ($this->renderer->canRender($result->getTemplate())) {
            $e->setViewModel($result);
            $e->setResult(null);
        }
    }
}