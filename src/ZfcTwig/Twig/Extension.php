<?php

namespace ZfcTwig\Twig;

use Twig_Extension;
use ZfcTwig\Twig\TokenParser\ViewHelperParser;
use ZfcTwig\Twig\TokenParser\ViewHelperBroker;

class Extension extends Twig_Extension
{
    /**
     * @var Environment
     */
    protected $env;

    public function __construct(Environment $env)
    {
        $this->env = $env;
    }

    public function getTokenParsers()
    {
        $broker = new ViewHelperBroker($this->env, new ViewHelperParser);

        return array($broker);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'ZfcTwig';
    }
}