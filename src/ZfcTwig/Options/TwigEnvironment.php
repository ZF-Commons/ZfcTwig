<?php

namespace ZfcTwig\Options;

use Zend\Stdlib\AbstractOptions;

class TwigEnvironment extends AbstractOptions
{
    /**
     * An array of extensions. Each extension should be a service manager
     * alias or the FQCN of the class to load.
     *
     * @var array
     */
    protected $extensions = array();

    /**
     * An array that will be passed directly to the instation of Twig_Environment.
     * @var array
     */
    protected $environment = array();

    /**
     * An array of service manager aliases that will be fed to the Twig_Chain used internally.
     * @var array
     */
    protected $loaders = array();

    /**
     * The suffix appended to template names.
     * @var string
     */
    protected $suffix = '.twig';

    /**
     * An array of types to never render.
     * @var array
     */
    protected $blacklist = array('.phtml');

    /**
     * @param array $blacklist
     * @return TwigEnvironment
     */
    public function setBlacklist($blacklist)
    {
        $this->blacklist = $blacklist;
        return $this;
    }

    /**
     * @return array
     */
    public function getBlacklist()
    {
        return $this->blacklist;
    }

    /**
     * @param string $suffix
     * @return TwigEnvironment
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
        return $this;
    }

    /**
     * @return string
     */
    public function getSuffix()
    {
        return $this->suffix;
    }

    /**
     * @param $extensions
     * @return TwigEnvironment
     */
    public function setExtensions($extensions)
    {
        $this->extensions = $extensions;
        return $this;
    }

    /**
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * @param array $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return array
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param array $loaders
     */
    public function setLoaders($loaders)
    {
        $this->loaders = $loaders;
        return $this;
    }

    /**
     * @return array
     */
    public function getLoaders()
    {
        return $this->loaders;
    }
}