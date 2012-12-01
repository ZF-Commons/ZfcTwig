<?php

namespace ZfcTwig\View\Renderer;

use RuntimeException;
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
     * @param Twig_Environment $environment
     */
    public function __construct(Twig_Environment $environment, TwigResolver $resolver)
    {
        $this->environment = $environment;
        $this->resolver    = $resolver;
    }

    /**
     * Magic call method that proxies to the plugin manager.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (!$this->getHelperPluginManager()->has($name)) {
            throw new RuntimeException('__call only supports loading plugins from the HelperPluginManager');
        }

        // Ensure the renderer is set to this instance.
        $this->getHelperPluginManager()->setRenderer($this);

        // Attempt to load the plugin.
        try {
            return call_user_func_array($this->getHelperPluginManager()->get($name), $arguments);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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