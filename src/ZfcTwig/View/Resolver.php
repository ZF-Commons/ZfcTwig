<?php

namespace ZfcTwig\View;

use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;
use ZfcTwig\Twig\Loader\Filesystem;

/**
 * View Resolver
 *
 * Can be used as both a Zend Resolver and a Twig resolver
 */
class Resolver extends Filesystem implements ResolverInterface
{
    /**
     * @param string $name
     * @param RendererInterface $renderer
     */
    public function resolve($name, RendererInterface $renderer = null)
    {
        return $this->findTemplate($name);
    }
}