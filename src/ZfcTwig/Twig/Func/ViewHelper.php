<?php

namespace ZfcTwig\Twig\Func;

use Twig_Function;
use Zend\View\Helper\HelperInterface;

class ViewHelper extends Twig_Function
{
    /**
     * @var HelperInterface
     */
    protected $helper;

    public function __construct($helper)
    {
        $this->helper = $helper;

        parent::__construct(array('is_safe' => array('all')));
    }

    /**
     * Compiles a function.
     *
     * @return string The PHP code for the function
     */
    public function compile()
    {
        return sprintf('$this->env->getExtension("zfc-twig")->getRenderer()->plugin("%s")->__invoke', $this->helper);
    }
}