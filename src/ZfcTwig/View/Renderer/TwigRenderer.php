<?php

namespace ZfcTwig\View\Renderer;

use Twig_Environment;
use Twig_Error_Loader;
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
     * @var string
     */
    protected $defaultSuffix = '.twig';

    /**
     * @param Twig_Environment $environment
     */
    public function __construct(Twig_Environment $environment, TwigResolver $resolver)
    {
        $this->environment = $environment;
        $this->resolver    = $resolver;
    }

    /**
     * Gets the canonical name.
     *
     * @param string $name
     * @return string
     */
    public function getCanonicalName($name)
    {
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        if (empty($ext)) {
            $name .= $this->getDefaultSuffix();
        }
        return $name;
    }

    /**
     * @param string $defaultSuffix
     * @return TwigRenderer
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
     * Proxy to \ZfcTwig\Twig\Environment::canLoadTemplate();
     *
     * @param string $name
     * @return bool
     * @see \ZfcTwig\Twig\Environment::canLoadTemplate()
     */
    public function canRender($name)
    {
        try {
            $this->environment->loadTemplate($this->getCanonicalName($name));
            return true;
        } catch (Twig_Error_Loader $e) {
            ; // intentionall left blank
        }

        return false;
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
     * Get plugin instance
     *
     * @param  string     $name Name of plugin to return
     * @param  null|array $options Options to pass to plugin constructor (if not already instantiated)
     * @return \Zend\View\Helper\AbstractHelper
     */
    public function plugin($name, array $options = null)
    {
        $this->getHelperPluginManager()->setRenderer($this);
        return $this->getHelperPluginManager()->get($name, $options);
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
    public function render($nameOrModel, $values = null)
    {
        $vars = array();
        if ($nameOrModel instanceof ModelInterface) {
            $model       = $nameOrModel;
            $nameOrModel = $model->getTemplate();

            if (empty($nameOrModel)) {
                throw new Exception\DomainException(sprintf(
                    '%s: received View Model argument, but template is empty', __METHOD__
                ));
            }

            $vars = (array) $model->getVariables();
        }

        $template = $this->resolver->resolve($this->getCanonicalName($nameOrModel), $this);
        if ($template) {
            return $template->render($vars);
        }
        return null;
    }
}