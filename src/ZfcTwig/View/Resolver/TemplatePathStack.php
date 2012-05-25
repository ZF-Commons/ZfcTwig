<?php

namespace ZfcTwig\View\Resolver;

use Zend\View\Resolver\TemplatePathStack as BaseTemplatePathStack;

class TemplatePathStack extends BaseTemplatePathStack
{
    protected $defaultSuffix = 'twig';
}