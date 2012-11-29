# ZfcTwig Module for Zend Framework 2 [![Master Branch Build Status](https://secure.travis-ci.org/ZF-Commons/ZfcTwig.png?branch=master)](http://travis-ci.org/ZF-Commons/ZfcTwig)

ZfcTwig is a module that integrates the [Twig](http://twig.sensiolabs.org) templating engine with
[Zend Framework 2](http://framework.zend.com).

## Installation

 1. Add `"zf-commons/zfc-twig": "dev-master"` to your `composer.json` file and run `php composer.phar update`.
 2. Add `ZfcTwig` to your `config/application.config.php` file under the `modules` key.

## Configuration

ZfcTwig has sane defaults out of the box but offers optional configuration via the `zfctwig` configuration key. For
detailed information on all available options see the [module config file](https://github.com/ZF-Commons/ZfcTwig/tree/master/config/module.config.php)
class.

## Documentation

### Setting up Twig extensions

Extensions can be registered with Twig by adding the FQCN to the `extensions` configuration key which is exactly how the
ZfcTwig extension is registered.

```php
// in module configuration or autoload override
return array(
    'zfctwig' => array(
        'extensions' => array(
            // an extension that uses no key
            'My\Custom\Extension',

            // an extension with a key so that you can remove it from another module
            'my_custom_extension' => 'My\Custom\Extension'
        )
    )
);
```

### Configuring Twig loaders

By default, ZfcTwig uses a Twig_Loader_Chain so that loaders can be chained together. A convenient default is setup using
a [filesystem loader](https://github.com/ZF-Commons/ZfcTwig/tree/master/Module.php#L36) with the path set to
`module/Application/view` which should work out of the box for most instances. If you wish to add additional loaders
to the chain you can register them by adding the service manager alias to the `loaders` configuration key.

```php
// in module configuration or autoload override
return array(
    'zfctwig' => array(
        'loaders' => array(
            'MyTwigFilesystemLoader'
        )
    )
);

// in some module
public function getServiceConfiguration()
{
    return array(
        'factories' => array(
            'MyTwigFilesystemLoader' => function($sm) {
                return new \Twig_Loader_Filesystem('my/custom/twig/path');
            }
        )
    );
}
```

### Using ZF2 View Helpers

Using ZF2 view helpers is supported through the [ZfcTwig\Twig\Func\ViewHelper](https://github.com/ZF-Commons/ZfcTwig/tree/master/src/ZfcTwig/Twig/Func/ViewHelper.php)
function.

```twig
{# Simple view helper echo #}
{{ docType() }}

{# Echo with additional methods #}
{{ headTitle('My Company').setSeparator('-') }}

{# Using a view helper without an echo #}
{% do headTitle().setSeparator('-') %}

{# Combining view helpers #}
{% set url = ( url('my/custom/route') ) %}
```

# Examples

Example .twig files for the skeleton application can be found in the [examples](https://github.com/ZF-Commons/ZfcTwig/tree/master/examples)
folder.