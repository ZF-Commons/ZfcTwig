<?php

namespace ZfcTwig\View\Resolver;

use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;

class TwigResolver implements ResolverInterface
{
    /**
     * @var string
     */
    protected $suffix = '.twig';

    /**
     * Resolve a template/pattern name to a resource the renderer can consume
     *
     * @param  string $name
     * @param  null|Renderer $renderer
     * @return mixed
     */
    public function resolve($name, RendererInterface $renderer = null)
    {
        return $name . $this->getSuffix();
    }

    /**
     * @param $suffix
     * @return TwigResolver
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
        return $this;
    }

    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

}