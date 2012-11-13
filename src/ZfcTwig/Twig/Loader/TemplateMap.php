<?php

namespace ZfcTwig\Twig\Loader;

use Twig_Error_Loader;
use Twig_LoaderInterface;
use Zend\View\Resolver\TemplateMapResolver;

class TemplateMap extends TemplateMapResolver implements Twig_LoaderInterface
{
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
        if (isset($this->map[$name])) {
            return file_get_contents($this->map[$name]);
        }

        throw new Twig_Error_Loader(sprintf(
            'Unable to find template "%s" from template map',
            $name
        ));
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
        return $name;
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string    $name The template name
     * @param timestamp $time The last modification time of the cached template
     *
     * @return Boolean true if the template is fresh, false otherwise
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function isFresh($name, $time)
    {
        return filemtime($name) <= $time;
    }
}