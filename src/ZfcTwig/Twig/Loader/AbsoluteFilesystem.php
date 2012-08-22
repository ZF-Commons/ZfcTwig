<?php

namespace ZfcTwig\Twig\Loader;

use Twig_Error_Loader;
use Twig_LoaderInterface;
use Zend\View\Resolver\ResolverInterface;

class AbsoluteFilesystem implements Twig_LoaderInterface
{
    /**
     * @var array
     */
    protected $cache;

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

    /**
     * Gets the source code of a template, given its name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The template source code
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getSource($name)
    {
        return file_get_contents($this->findTemplate($name));
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The cache key
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getCacheKey($name)
    {
        return $this->findTemplate($name);
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string $name The template name
     * @param int    $time The last modification time of the cached template
     *
     * @return Boolean true if the template is fresh, false otherwise
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function isFresh($name, $time)
    {
        return filemtime($this->findTemplate($name)) <= $time;
    }

    /**
     * @param $name
     * @return array
     * @throws \Twig_Error_Loader
     */
    protected function findTemplate($name)
    {
        $name = preg_replace('#/{2,}#', '/', strtr($name, '\\', '/'));

        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        if (is_file($name)) {
            return $this->cache[$name] = $name;
        } else if (($fallbackName = $this->fallbackResolver->resolve($name))) {
            return $this->cache[$fallbackName] = $fallbackName;
        }

        throw new Twig_Error_Loader(sprintf('Unable to find template "%s".', $name));
    }
}