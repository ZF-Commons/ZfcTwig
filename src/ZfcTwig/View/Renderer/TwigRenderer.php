<?php

namespace ZfcTwig\View\Renderer;

use Twig_Environment;
use Zend\View\Exception;
use Zend\View\HelperPluginManager;
use Zend\View\Model\ModelInterface;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;
use ZfcTwig\View\Resolver\TwigResolver;

class TwigRenderer implements RendererInterface
{
    /**
     * @var Twig_Environment
     */
    protected $environment;

    /**
     * @var HelperPluginManager
     */
    protected $helperPluginManager;

    /**
     * @var TwigResolver
     */
    protected $resolver;

    /**
     * @var array Cache for the plugin call
     */
    private $__pluginCache = array();

    /**
     * @param \Twig_Environment $environment
     * @param TwigResolver      $resolver
     */
    public function __construct(Twig_Environment $environment, TwigResolver $resolver)
    {
        $this->environment = $environment;
        $this->resolver    = $resolver;
    }

    /**
     * Overloading: proxy to helpers
     *
     * Proxies to the attached plugin manager to retrieve, return, and potentially
     * execute helpers.
     *
     * * If the helper does not define __invoke, it will be returned
     * * If the helper does define __invoke, it will be called as a functor
     *
     * @param  string $method
     * @param  array $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        if (!isset($this->__pluginCache[$method])) {
            $this->__pluginCache[$method] = $this->plugin($method);
        }
        if (is_callable($this->__pluginCache[$method])) {
            return call_user_func_array($this->__pluginCache[$method], $argv);
        }
        return $this->__pluginCache[$method];
    }

    /**
     * Get plugin instance, proxy to HelperPluginManager::get
     *
     * @param  string     $name Name of plugin to return
     * @param  null|array $options Options to pass to plugin constructor (if not already instantiated)
     * @return \Zend\View\Helper\AbstractHelper
     */
    public function plugin($name, array $options = null)
    {
        return $this->getHelperPluginManager()
                    ->setRenderer($this)
                    ->get($name, $options);
    }

    /**
     * Can the template be rendered?
     *
     * @param string $name
     * @return bool
     * @see \ZfcTwig\Twig\Environment::canLoadTemplate()
     */
    public function canRender($name)
    {
        return $this->resolver->resolve($name, $this);
    }

    /**
     * Return the template engine object, if any
     *
     * If using a third-party template engine, such as Smarty, patTemplate,
     * phplib, etc, return the template engine object. Useful for calling
     * methods on these objects, such as for setting filters, modifiers, etc.
     *
     * @return Twig_Environment
     */
    public function getEngine()
    {
        return $this->environment;
    }

    /**
     * Set the resolver used to map a template name to a resource the renderer may consume.
     *
     * @param  ResolverInterface $resolver
     * @return TwigRenderer
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
        return $this;
    }

    /**
     * @param HelperPluginManager $helperPluginManager
     * @return TwigRenderer
     */
    public function setHelperPluginManager(HelperPluginManager $helperPluginManager)
    {
        $helperPluginManager->setRenderer($this);
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
     * Processes a view script and returns the output.
     *
     * @param  string|ModelInterface   $nameOrModel The script/resource process, or a view model
     * @param  null|array|\ArrayAccess $values      Values to use during rendering
     * @return string|null The script output.
     * @throws \Zend\View\Exception\DomainException
     */
    public function render($nameOrModel, $values = array())
    {
        if ($nameOrModel instanceof ModelInterface) {
            $model       = $nameOrModel;
            $nameOrModel = $model->getTemplate();

            if (empty($nameOrModel)) {
                throw new Exception\DomainException(sprintf(
                    '%s: received View Model argument, but template is empty', __METHOD__
                ));
            }

            $values = (array) $model->getVariables();
        }

        /** @var $template \Twig_Template */
        $template = $this->resolver->resolve($nameOrModel, $this);
        if ($template) {
            return $template->render($values);
        }
        return null;
    }
}