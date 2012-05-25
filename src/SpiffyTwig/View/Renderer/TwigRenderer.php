<?php

namespace SpiffyTwig\View\Renderer;

use SpiffyTwig\View\Resolver\TemplatePathStack;
use SpiffyTwig\View\Exception;
use Twig_Environment;
use Zend\Loader\Pluggable;
use Zend\View\Model\ModelInterface;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Renderer\TreeRendererInterface;
use Zend\View\Resolver\ResolverInterface;

class TwigRenderer implements RendererInterface, Pluggable, TreeRendererInterface
{
    /**
     * @var \Twig_Environment
     */
    protected $engine;

    /**
     * @var \SpiffyTwig\View\Resolver\TemplatePathStack
     */
    protected $resolver;

    /**
     * Get plugin broker instance
     *
     * @return Zend\Loader\Broker
     */
    public function getBroker()
    {
        // TODO: Implement getBroker() method.
    }

    /**
     * Set plugin broker instance
     *
     * @param  string|Broker $broker Plugin broker to load plugins
     * @return Zend\Loader\Pluggable
     */
    public function setBroker($broker)
    {
        // TODO: Implement setBroker() method.
    }

    /**
     * Get plugin instance
     *
     * @param  string     $plugin  Name of plugin to return
     * @param  null|array $options Options to pass to plugin constructor (if not already instantiated)
     * @return mixed
     */
    public function plugin($name, array $options = null)
    {
        // TODO: Implement plugin() method.
    }

    public function setEngine(Twig_Environment $engine)
    {
        $this->engine = $engine;
        return $this;
    }

    /**
     * Return the template engine object, if any
     *
     * If using a third-party template engine, such as Smarty, patTemplate,
     * phplib, etc, return the template engine object. Useful for calling
     * methods on these objects, such as for setting filters, modifiers, etc.
     *
     * @return \Twig_Environment
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set the resolver used to map a template name to a resource the renderer may consume.
     *
     * @param  Resolver $resolver
     * @return RendererInterface
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
        return $this;
    }

    /**
     * Retrieve template name or template resolver
     *
     * @param  null|string $name
     * @return string|Resolver
     */
    public function resolver($name = null)
    {
        if (null === $this->resolver) {
            $this->setResolver(new TemplatePathStack());
        }

        if (null !== $name) {
            return $this->resolver->resolve($name, $this);
        }

        return $this->templateResolver;
    }

    /**
     * Processes a view script and returns the output.
     *
     * @param  string|Model $name The script/resource process, or a view model
     * @param  null|array|\ArrayAccess Values to use during rendering
     * @return string The script output.
     */
    public function render($nameOrModel, $values = null)
    {
        if ($nameOrModel instanceof ModelInterface) {
            $model       = $nameOrModel;
            $nameOrModel = $model->getTemplate();
            if (empty($nameOrModel)) {
                throw new Exception\DomainException(sprintf(
                    '%s: received View Model argument, but template is empty',
                    __METHOD__
                ));
            }
            $options = $model->getOptions();
            foreach ($options as $setting => $value) {
                $method = 'set' . $setting;
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
                unset($method, $setting, $value);
            }
            unset($options);

            // Give view model awareness via ViewModel helper
            //$helper = $this->plugin('view_model');
            //$helper->setCurrent($model);

            $values = $model->getVariables();
            unset($model);
        }

        if (is_object($values)) {
            $values = $values->getArrayCopy();
        }

        return $this->getEngine()->render($nameOrModel . '.twig', $values);
    }

    /**
     * Indicate whether the renderer is capable of rendering trees of view models
     *
     * @return bool
     */
    public function canRenderTrees()
    {
        // TODO: Implement canRenderTrees() method.
    }
}