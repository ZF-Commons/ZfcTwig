<?php

namespace ZfcTwig\Twig\Node;

use Twig_Compiler;
use Twig_Node;

class ViewHelper extends Twig_Node
{
    /**
     * {@inheritDoc}
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this)
                 ->addIndentation()
                 ->subcompile($this->getNode('expression'))
                 ->raw(";\n");
    }
}