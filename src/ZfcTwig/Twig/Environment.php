<?php

namespace ZfcTwig\Twig;

use Twig_Environment;
use Twig_Error_Loader;
use Twig_TemplateInterface;
use Zend\View\HelperPluginManager;
use ZfcTwig\Options\TwigEnvironment as TwigEnvironmentOptions;

class Environment extends Twig_Environment
{
    /**
     * @var HelperPluginManager
     */
    protected $helperPluginManager;

    /**
     * @var string
     */
    protected $defaultSuffix = '.twig';

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @param string $defaultSuffix
     * @return Environment
     */
    public function setDefaultSuffix($defaultSuffix)
    {
        $this->defaultSuffix = $defaultSuffix;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultSuffix()
    {
        return $this->defaultSuffix;
    }

    /**
     * Determines if a template is loadable by calling loadTemplate and catching
     * exceptions.
     *
     * @param string $name
     * @return boolean
     */
    public function canLoadTemplate($name)
    {
        try {
            $this->loadTemplate($name);
            return true;
        } catch (Twig_Error_Loader $e) {
            ; // intentionall left blank
        }

        return false;
    }

    /**
     * Loads a template by name.
     *
     * @param string  $name  The template name
     * @param integer $index The index if it is an embedded template
     *
     * @return Twig_TemplateInterface A template instance representing the given template name
     */
    public function loadTemplate($name, $index = null)
    {
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        if (empty($ext)) {
            $name .= $this->getDefaultSuffix();
        }

        return parent::loadTemplate($name, $index);
    }

    /**
     * @param HelperPluginManager $helperPluginManager
     * @return Environment
     */
    public function setHelperPluginManager(HelperPluginManager $helperPluginManager)
    {
        $this->helperPluginManager = $helperPluginManager;
        return $this;
    }

    /**
     * @return \Zend\View\HelperPluginManager
     */
    public function getHelperPluginManager()
    {
        return $this->helperPluginManager;
    }

    /**
     * @param TwigEnvironmentOptions $options
     */
    public function setZfcTwigOptions(TwigEnvironmentOptions $options)
    {
        $this->options = $options;
    }

    /**
     * @return TwigEnvironmentOptions
     */
    public function getZfcTwigOptions()
    {
        if (null === $this->options) {
            $this->options = new TwigEnvironmentOptions();
        }
        return $this->options;
    }
}