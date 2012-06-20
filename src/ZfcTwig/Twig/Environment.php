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
    protected $php_fallback;

    function __construct(\Twig_LoaderInterface $loader = null, $options = array())
    {
        parent::__construct($loader, $options);
        $options = array_merge(array(
            'allow_php_fallback' => false
        ), $options);
        $this->php_fallback = $options['allow_php_fallback'];
    }

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

        try{
            if ($this->plugin($name)){
                $function = new ViewHelper($name);

                $this->addFunction($name, $function);
                return $function;
            }
        }catch(\Exception $exception){

        }

        if ($this->php_fallback){
            $constructs = array('isset', 'empty');
            $_name = $name;
            if (function_exists($_name) || in_array($_name, $constructs)) {
                $function = new \Twig_Function_Function($_name);
                $this->addFunction($name, $function);
                return $function;
            }
        }

        return false;
    }
}