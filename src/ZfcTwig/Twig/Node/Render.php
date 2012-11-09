<?php
namespace ZfcTwig\Twig\Node;

use Twig_Node;
use Twig_Node_Expression as Expression;
use Twig_Compiler as Compiler;

class Render extends Twig_Node
{
    /**
     * {@inheritDoc}
     */
    public function __construct(Expression $expr, Expression $attributes, Expression $options, $lineno, $tag = null)
    {
        parent::__construct(
            array(
                'expr' => $expr,
                'attributes' => $attributes,
                'options' => $options
            ),
            array(), $lineno, $tag);
    }

    /**
     * {@inheritDoc}
     */
    public function compile(Compiler $compiler)
    {
        $compiler
            ->addDebugInfo($this)
            ->write("echo \$this->env->getExtension('ZfcTwig')->getHelper('render')->__invoke(")
            ->subcompile($this->getNode('expr'))
            ->raw(', ')
            ->subcompile($this->getNode('attributes'))
            ->raw(', ')
            ->subcompile($this->getNode('options'))
            ->raw(");\n");
    }
}