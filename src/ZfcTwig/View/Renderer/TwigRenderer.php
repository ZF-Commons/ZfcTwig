<?php

namespace ZfcTwig\View\Renderer;

use ArrayAccess;
use ZfcTwig\View\Resolver\TemplatePathStack;
use ZfcTwig\View\Exception;
use Twig_Environment;
use Zend\Loader\Pluggable;
use Zend\View\Model\ModelInterface;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Renderer\TreeRendererInterface;
use Zend\View\Resolver\ResolverInterface;
use Zend\View\Variables;

class TwigRenderer implements RendererInterface, Pluggable, TreeRendererInterface
{
    /**
     * @var \Twig_Environment
     */
    protected $engine;

    /**
     * @var \ZfcTwig\View\Resolver\TemplatePathStack
     */
    protected $resolver;

    /**
     * @var ArrayAccess|array
     */
    protected $vars;

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
     * Set variable storage
     *
     * Expects either an array, or an object implementing ArrayAccess.
     *
     * @param  array|ArrayAccess $variables
     * @return PhpRenderer
     * @throws Exception\InvalidArgumentException
     */
    public function setVars($variables)
    {
        if (!is_array($variables) && !$variables instanceof ArrayAccess) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Expected array or ArrayAccess object; received "%s"',
                (is_object($variables) ? get_class($variables) : gettype($variables))
            ));
        }

        // Enforce a Variables container
        if (!$variables instanceof Variables) {
            $variablesAsArray = array();
            foreach ($variables as $key => $value) {
                $variablesAsArray[$key] = $value;
            }
            $variables = new Variables($variablesAsArray);
        }

        $this->vars = $variables;
        return $this;
    }

    /**
     * Get a single variable, or all variables
     *
     * @param  mixed $key
     * @return mixed
     */
    public function vars($key = null)
    {
        if (null === $this->vars) {
            $this->setVars(new Variables());
        }

        if (null === $key) {
            return $this->vars;
        }
        return $this->vars[$key];
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

            // TODO: talk with Matthew about working around this.
            // This line disables the layout from being rendered.
            $model->setTerminal(true);

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

        if (null !== $values) {
            $this->setVars($values);
        }

        return $this->getEngine()->render($nameOrModel . '.twig', $this->vars()->getArrayCopy());
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