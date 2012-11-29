<?php

namespace ZfcTwig\Twig\Extension;

use Twig_Extension;
use ZfcTwig\View\Renderer\TwigRenderer;

class ZfcTwig extends Twig_Extension
{
    /**
     * @var TwigRenderer
     */
    protected $renderer;

    /**
     * Constructor.
     *
     * @param TwigRenderer $helperPluginManager
     */
    public function __construct(TwigRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @return \Zend\View\HelperPluginManager
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'zfc-twig';
    }
}