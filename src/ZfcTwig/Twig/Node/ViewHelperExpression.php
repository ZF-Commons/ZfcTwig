<?php

namespace ZfcTwig\Twig\Node;

use Twig_Compiler;
use Twig_Node_Expression;

class ViewHelperExpression extends Twig_Node_Expression
{
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->raw('$this->env->plugin(');
        $compiler->repr($this->getAttribute('helperName'));
        $compiler->raw(')->__invoke(');

        foreach($this->getNode('arguments') as $key => $value) {
            if ($key > 0) {
                $compiler->raw(', ');
            }
            $compiler->subcompile($value);
        }

        $compiler->raw(")");
    }
}