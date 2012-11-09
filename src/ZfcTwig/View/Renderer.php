<?php

namespace ZfcTwig\View;

use Twig_Environment;
use Twig_Error_Loader;
use Zend\View\Exception;
use Zend\View\Model\ModelInterface;
use Zend\View\Renderer\PhpRenderer;

class Renderer extends PhpRenderer
{

    /**
     * @var Twig_Environment
     */
    protected $engine;

    /**
     * @var bool
     */
    protected $suffixLocked;

    /**
     * @var string
     */
    protected $suffix;

    /**
     * @param Twig_Environment $engine
     * @return Renderer
     */
    public function setEngine(Twig_Environment $engine)
    {
        $this->engine = $engine;
        return $this;
    }

    /**
     * @return Twig_Environment
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param $nameOrModel
     */
    public function canRender($nameOrModel)
    {
        if ($nameOrModel instanceof ModelInterface) {
            $nameOrModel = $nameOrModel->getTemplate();
        }

        if (!$this->getSuffixLocked()) {
            return true;
        }

        $tpl = $this->resolver()->resolve($nameOrModel);
        $ext = pathinfo($tpl, PATHINFO_EXTENSION);

        if ($ext == $this->getSuffix()) {
            return true;
        }

        return false;
    }

    /**
     * Processes a view script and returns the output.
     *
     * @param  string|ModelInterface $nameOrModel The script/resource process, or a view model
     * @param  null|array|\ArrayAccess Values to use during rendering
     * @return string The script output.
     * @throws \Twig_Error_Loader
     * @throws \Zend\View\Exception\DomainException
     */
    public function render($nameOrModel, $values = null)
    {
        if ($nameOrModel instanceof ModelInterface) {
            $model = $nameOrModel;
            $nameOrModel = $model->getTemplate();

            if (empty($nameOrModel)) {
                throw new Exception\DomainException(sprintf(
                    '%s: received View Model argument, but template is empty', __METHOD__
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

            $values = $model->getVariables();
            unset($model);
        }

        if (null !== $values) {
            $this->setVars($values);
        }
        
        $twig = $this->getEngine();
        $vars = $this->vars()->getArrayCopy();
        
        if (!$this->canRender($nameOrModel)) {
            throw new Twig_Error_Loader(sprintf('Unable to find template "%s".', $nameOrModel));
        }

        return $this->getFilterChain()->filter($twig->render($nameOrModel, $vars));
    }

    /**
     * @param boolean $suffixLocked
     * @return Renderer
     */
    public function setSuffixLocked($suffixLocked)
    {
        $this->suffixLocked = $suffixLocked;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getSuffixLocked()
    {
        return $this->suffixLocked;
    }

    /**
     * @param string $suffix
     * @return Renderer
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