<?php

namespace ZfcTwig\Twig\Loader;

use Twig_Error_Loader;
use Twig_Loader_Filesystem;
use Zend\View\Resolver\ResolverInterface;

class Filesystem extends Twig_Loader_Filesystem
{

    /**
     * @var \Zend\View\Resolver\ResolverInterface
     */
    protected $fallbackResolver;

    /**
     * The fallback renderer is used to resolve files that were unable to be found
     * using an absolute path, specifically, for instances such as the {% extends %}
     * method in Twig.
     *
     * @param \Zend\View\Resolver\ResolverInterface $fallbackResolver
     * @return AbsoluteFilesystem
     */
    public function setFallbackResolver(ResolverInterface $fallbackResolver)
    {
        $this->fallbackResolver = $fallbackResolver;
        return $this;
    }

    protected function findTemplate($name)
    {
        // normalize name
        $name = preg_replace('#/{2,}#', '/', strtr($name, '\\', '/'));

        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        $this->validateName($name);

        $namespace = '__main__';
        if (isset($name[0]) && '@' == $name[0]) {
            if (false === $pos = strpos($name, '/')) {
                throw new Twig_Error_Loader(sprintf('Malformed namespaced template name "%s" (expecting "@namespace/template_name").', $name));
            }

            $namespace = substr($name, 1, $pos - 1);

            $name = substr($name, $pos + 1);
        }


        if (!isset($this->paths[$namespace])) {
            throw new Twig_Error_Loader(sprintf('There are no registered paths for namespace "%s".', $namespace));
        }

        if ($namespace == '__main__' && ($fallbackName = $this->fallbackResolver->resolve($name))) {
            return $this->cache[$fallbackName] = $fallbackName;
        }

        foreach ($this->paths[$namespace] as $path) {
            if (is_file($path . '/' . $name)) {
                return $this->cache[$name] = $path . '/' . $name;
            }
        }

        throw new Twig_Error_Loader(sprintf('Unable to find template "%s" (looked into: %s).', $name, implode(', ', $this->paths[$namespace])));
    }

}