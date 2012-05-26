<?php

namespace ZfcTwig\Twig;

use Twig_Environment;
use ZfcTwig\Twig\Func\ViewHelper;
use Zend\View\HelperBroker;

class Environment extends Twig_Environment
{
    /**
     * @var \Zend\View\HelperBroker
     */
    protected $broker;

    /**
     * @return \Zend\View\HelperBroker
     */
    public function broker()
    {
        return $this->broker;
    }

    /**
     * @param $name string
     */
    public function plugin($name)
    {
        return $this->broker()->load($name);
    }

    /**
     * @param \Zend\View\HelperBroker $broker
     * @return Environment
     */
    public function setBroker(HelperBroker $broker)
    {
        $this->broker = $broker;
        return $this;
    }

    public function getFunction($name)
    {
        if (($function = parent::getFunction($name))) {
            return $function;
        }

        $function = new ViewHelper($name);

        $this->addFunction($name, $function);
        return $function;
    }
}