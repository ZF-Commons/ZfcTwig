<?php

namespace ZfcTwig;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var
     */
    protected $environmentLoader;

    /**
     * @var array
     */
    protected $environmentOptions = array();

    /**
     * @var array
     */
    protected $loaderChain = array();

    /**
     * @var array
     */
    protected $extensions = array();

    /**
     * @var string
     */
    protected $suffix;

    /**
     * @var bool
     */
    protected $enableFallbackFunctions = true;

    /**
     * @var bool
     */
    protected $disableZfmodel = true;

    /**
     * @var array
     */
    protected $helperManager = array();

    /**
     * @param boolean $disableZfmodel
     * @return ModuleOptions
     */
    public function setDisableZfmodel($disableZfmodel)
    {
        $this->disableZfmodel = $disableZfmodel;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getDisableZfmodel()
    {
        return $this->disableZfmodel;
    }

    /**
     * @param boolean $enableFallbackFunctions
     * @return ModuleOptions
     */
    public function setEnableFallbackFunctions($enableFallbackFunctions)
    {
        $this->enableFallbackFunctions = $enableFallbackFunctions;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getEnableFallbackFunctions()
    {
        return $this->enableFallbackFunctions;
    }

    /**
     * @param mixed $environmentLoader
     * @return ModuleOptions
     */
    public function setEnvironmentLoader($environmentLoader)
    {
        $this->environmentLoader = $environmentLoader;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnvironmentLoader()
    {
        return $this->environmentLoader;
    }

    /**
     * @param array $environmentOptions
     * @return ModuleOptions
     */
    public function setEnvironmentOptions($environmentOptions)
    {
        $this->environmentOptions = $environmentOptions;
        return $this;
    }

    /**
     * @return array
     */
    public function getEnvironmentOptions()
    {
        return $this->environmentOptions;
    }

    /**
     * @param array $extensions
     * @return ModuleOptions
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
     * @param array $helperManager
     * @return ModuleOptions
     */
    public function setHelperManager($helperManager)
    {
        $this->helperManager = $helperManager;
        return $this;
    }

    /**
     * @return array
     */
    public function getHelperManager()
    {
        return $this->helperManager;
    }

    /**
     * @param array $loaderChain
     * @return ModuleOptions
     */
    public function setLoaderChain($loaderChain)
    {
        $this->loaderChain = $loaderChain;
        return $this;
    }

    /**
     * @return array
     */
    public function getLoaderChain()
    {
        return $this->loaderChain;
    }

    /**
     * @param string $suffix
     * @return ModuleOptions
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
}

