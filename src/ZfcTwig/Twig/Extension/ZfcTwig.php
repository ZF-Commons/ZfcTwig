<?php

namespace ZfcTwig\Twig\Extension;

use Twig_Environment;
use Twig_Extension;
use Zend\View\HelperPluginManager;
use ZfcTwig\Twig\Func\ViewHelper;

class ZfcTwig extends Twig_Extension
{
    /**
     * @var HelperPluginManager
     */
    protected $helperPluginManager;

    public function __construct(HelperPluginManager $helperPluginManager)
    {
        $this->helperPluginManager = $helperPluginManager;
    }

    /**
     * Initializes the runtime environment.
     *
     * This is where you can load some file that contains filter functions for instance.
     *
     * @param Twig_Environment $environment The current Twig_Environment instance
     */
    public function initRuntime(Twig_Environment $environment)
    {
        $helperPluginmanager = $this->helperPluginManager;
        $environment->registerUndefinedFunctionCallback(function($name) use ($helperPluginmanager) {
            if ($helperPluginmanager->has($name)) {
                return new ViewHelper($name);
            }
            return null;
        });
    }

    /**
     * @return \Zend\View\HelperPluginManager
     */
    public function getHelperPluginManager()
    {
        return $this->helperPluginManager;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'zfc-twig';
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array();
    }

    /**
     * Returns the token parser instances to add to the existing list.
     *
     * @return array An array of Twig_TokenParserInterface or Twig_TokenParserBrokerInterface instances
     */
    public function getTokenParsers()
    {
        return array();
    }
}