<?php

namespace ZfcTwig\View\Renderer;

use ZfcTwig\View\Exception;
use Twig_Environment;
use Zend\View\Model\ModelInterface;
use Zend\View\Renderer\PhpRenderer;

class TwigRenderer extends PhpRenderer
{
    /**
     * @var \Twig_Environment
     */
    protected $engine;

    /**
     * @param \Twig_Environment $engine
     * @return TwigRenderer
     */
    public function setEngine(Twig_Environment $engine)
    {
        $this->engine = $engine;
        return $this;
    }

    /**
     * @return \Twig_Environment
     */
    public function getEngine()
    {
        return $this->engine;
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

            $values = $model->getVariables();
        }

        if (null !== $values) {
            $this->setVars($values);
        }

        $file = $this->resolver()->resolve($nameOrModel);
        $vars = $this->vars()->getArrayCopy();
        $twig = $this->getEngine();

        return $this->getFilterChain()->filter($twig->render($file, $vars));
    }
}