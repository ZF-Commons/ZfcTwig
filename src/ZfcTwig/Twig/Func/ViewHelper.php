<?php

namespace ZfcTwig\Twig\Func;

use Twig_Function;
use Twig_Node;

class ViewHelper extends Twig_Function
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;

        parent::__construct(array('is_safe' => array('html')));
    }

    public function getSafe(Twig_Node $functionArgs)
    {
        if (isset($this->options['is_safe'])) {
            return $this->options['is_safe'];
        }

        if (isset($this->options['is_safe_callback'])) {
            return call_user_func($this->options['is_safe_callback'], $functionArgs);
        }

        return array();
    }

    /**
     * Compiles a function.
     *
     * @return string The PHP code for the function
     */
    function compile()
    {
        return sprintf("\$this->env->plugin('%s')->__invoke", $this->name);
    }
}