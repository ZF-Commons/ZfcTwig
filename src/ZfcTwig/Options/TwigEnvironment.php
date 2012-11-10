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
     * Specify whether or not to use the parent/child ViewModel style of
     * ZF2 proper. If set to false, you should not use Twig's inheritance.
     * @var bool
     */
    protected $disableZfModel = true;

    /**
     * @param string $suffix
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
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
     */
    public function setExtensions($extensions)
    {
        $this->extensions = $extensions;
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
    }

    /**
     * @return array
     */
    public function getLoaders()
    {
        return $this->loaders;
    }

    /**
     * @param boolean $disableZfModel
     */
    public function setDisableZfModel($disableZfModel)
    {
        $this->disableZfModel = $disableZfModel;
    }

    /**
     * @return boolean
     */
    public function getDisableZfModel()
    {
        return $this->disableZfModel;
    }
}