<?php

namespace ZfcTwig\View\Renderer;

use Zend\View\Exception;
use Zend\View\Model\ModelInterface;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;
use ZfcTwig\Twig\Environment;
use ZfcTwig\View\Resolver\TwigResolver;

class TwigRenderer implements RendererInterface
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @var TwigResolver
     */
    protected $resolver;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment, TwigResolver $resolver)
    {
        $this->environment = $environment;
        $this->resolver    = $resolver;
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
        return $this->environment->canLoadTemplate($name);
    }

    /**
     * Return the template engine object, if any
     *
     * If using a third-party template engine, such as Smarty, patTemplate,
     * phplib, etc, return the template engine object. Useful for calling
     * methods on these objects, such as for setting filters, modifiers, etc.
     *
     * @return Environment
     */
    public function getEngine()
    {
        return $this->environment;
    }

    /**
     * Set the resolver used to map a template name to a resource the renderer may consume.
     *
     * @param  ResolverInterface $resolver
     * @return RendererInterface
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
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

        $template = $this->resolver->resolve($nameOrModel, $this);
        if ($template) {
            return $template->render($vars);
        }
        return null;
    }
}