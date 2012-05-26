ZfcTwig
=======
ZfcTwig is a module that integrates the [Twig](http://twig.sensiolabs.org) templating engine with
[Zend Framework 2](http://framework.zend.com).

Installation
------------
 1. Add `"zf-commons/zfc-twig": "dev-master"` to your `composer.json` file and run `php composer.phar update`.
 2. Add `ZfcTwig` to your `config/application.config.php` file under the `modules` key.

Configuration
-------------
ZfcTwig has sane defaults out of the box but offers optional configuration via the `zfctwig` configuration key.

    `config` - passed directly to the Twig_Environment class.
    `suffix` - the suffix to use for Twig templates, default is .twig.

Examples
--------
Example .twig files for the skeleton application can be found in the
[examples](https://github.com/ZF-Commons/ZfcTwig/tree/master/examples) folder.