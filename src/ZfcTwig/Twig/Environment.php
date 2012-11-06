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
     * 
     * 
     * @var boolean
     */
    protected $allowPhpFallback;

    public function __construct(\Twig_LoaderInterface $loader = null, $options = array())
    {
        parent::__construct($loader, $options);

        $defaults = array(
            'allow_php_fallback' => false
        );

        $options = array_merge($defaults, $options);

        $this->allowPhpFallback = (bool)$options['allow_php_fallback'];
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
     * @return object
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

    /**
     * @param string $name
     * @return \ZfcTwig\Twig\Func\ViewHelper|\Twig_Function_Function|boolean
     */
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

        if ($this->allowPhpFallback){
            $constructs = array('isset', 'empty');
            if (function_exists($name) || in_array($name, $constructs)) {
                $function = new \Twig_Function_Function($name);
                $this->addFunction($name, $function);
                return $function;
            }
        }

        return false;
    }
}