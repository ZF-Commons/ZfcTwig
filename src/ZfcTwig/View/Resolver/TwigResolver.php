<?php

namespace ZfcTwig\View\Resolver;

use Twig_Environment;
use ZfcTwig\View\Renderer\TwigRenderer;
use Zend\View\Resolver\ResolverInterface;
use Zend\View\Renderer\RendererInterface as Renderer;

class TwigResolver implements ResolverInterface
{
    /**
     * @var Twig_Environment
     */
    protected $environment;

    public function __construct(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Resolve a template/pattern name to a resource the renderer can consume
     *
     * @param  string $name
     * @param  null|Renderer $renderer
     * @return mixed
     */
    public function resolve($name, Renderer $renderer = null)
    {
        if ($renderer instanceof TwigRenderer) {
            return $this->environment->loadTemplate($name);
        }
        return false;
    }
}