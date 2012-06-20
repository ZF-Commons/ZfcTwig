<?php

namespace ZfcTwig\Twig;

use Twig_Extension,
    ZfcTwig\Twig\TokenParser\ViewHelperParser,
    ZfcTwig\Twig\TokenParser\ViewHelperBroker,
    ZfcTwig\Twig\TokenParser\RenderParser,
    ZfcTwig\Twig\TokenParser\TriggerParser,
    ZfcTwig\Twig\Helper\Render as RenderHelper,
    ZfcTwig\Twig\Helper\Trigger as TriggerHelper;

class Extension extends Twig_Extension
{
    /**
     * @var Environment
     */
    protected $env;

    protected $helpers = array();

    public function __construct(Environment $env)
    {
        $this->env = $env;
        $this->helpers = array(
            'render' => new RenderHelper(),
            'trigger' => new TriggerHelper(),
        );
    }

    public function getTokenParsers()
    {
        $broker = new ViewHelperBroker($this->env, new ViewHelperParser);

        return array(
            $broker,
            new RenderParser(),
            new TriggerParser(),
        );
    }

    public function getHelper($name)
    {
        if (isset($this->helpers[$name])){
            return $this->helpers[$name];
        }

        throw new \Exception('Invalid ZfcTwig extension helper requested: "'.$name.'".');
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