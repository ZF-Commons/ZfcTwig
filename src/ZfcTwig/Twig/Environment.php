<?php

namespace ZfcTwig\Twig;

use Twig_Environment;
use ZfcTwig\Twig\Func\ViewHelper;
use Zend\View\HelperPluginManager;

class Environment extends Twig_Environment
{
    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $manager;

    /**
     * @return \Zend\View\HelperPluginManager
     */
    public function manager()
    {
        return $this->manager;
    }

    /**
     * @param $name string
     */
    public function plugin($name)
    {
        return $this->manager()->get($name);
    }

    /**
     * @param \Zend\View\HelperPluginManager $manager
     * @return Environment
     */
    public function setManager(HelperPluginManager $manager)
    {
        $this->manager = $manager;
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