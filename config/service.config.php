<?php

namespace ZfcTwig;

return array(
    'factories' => array(
        'TwigEnvironment'   => 'ZfcTwig\Service\EnvironmentFactory',
        'TwigViewRenderer'  => 'ZfcTwig\Service\ViewRendererFactory',
        'TwigViewStrategy'  => 'ZfcTwig\Service\ViewStrategyFactory',
        'TwigViewResolver'  => 'ZfcTwig\Service\ViewResolverFactory',
    )
);