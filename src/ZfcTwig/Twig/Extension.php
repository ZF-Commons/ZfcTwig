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
    
    /**
     * @var array
     */
    protected $helpers = array();

    public function __construct(Environment $env, $serviceLocator = null)
    {
        $this->env = $env;
        $this->helpers = array(
            'render' => new RenderHelper($serviceLocator),
            'trigger' => new TriggerHelper($serviceLocator),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getTokenParsers()
    {
        $broker = new ViewHelperBroker($this->env, new ViewHelperParser);

        return array(
            $broker,
            new RenderParser(),
            new TriggerParser(),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getHelper($name)
    {
        if (isset($this->helpers[$name])){
            return $this->helpers[$name];
        }

        throw new \Exception('Invalid ZfcTwig extension helper requested: "'.$name.'".');
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ZfcTwig';
    }
}