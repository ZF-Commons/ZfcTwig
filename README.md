# ZfcTwig

ZfcTwig is a module that integrates the [Twig](http://twig.sensiolabs.org) templating engine with
[Zend Framework 2](http://framework.zend.com).

## Installation

 1. Add `"zf-commons/zfc-twig": "dev-master"` to your `composer.json` file and run `php composer.phar update`.
 2. Add `ZfcTwig` to your `config/application.config.php` file under the `modules` key.

## Configuration

ZfcTwig has sane defaults out of the box but offers optional configuration via the `zfctwig` configuration key.

    `config` - passed directly to the Twig_Environment class. 
             - Added `allow_php_fallback` to allow fallback to php functions if the called function was not found.
               Active by default.
    `suffix` - the suffix to use for Twig templates, default is .twig.
    
ZfcTwig integrates with the View Manager service and uses the same resolvers defined within that service. 
This allows you to define the template path stacks and maps within the view manager without having to set them again
when installing the module:

    'view_manager' => array(
        'template_path_stack'   => array(
            'application'              => __DIR__ . '/../views',
        ),
        'template_map' => array(
            'layouts/layout'    => __DIR__ . '/../views/layouts/layout.twig',
            'index/index'       => __DIR__ . '/../views/application/index/index.twig',
        ),
    ), 

## Documentation


### View Helpers

Any command from the original Twig library should work and also added support for Zend View helpers as functions and
PHP functions as a fallback.

To use Zend View helpers you just need to invoke them as a function:

    {{ headTitle() }}

In case you just want to execute a view helper without rendering it you can use the twig `do` tag:

    {% do headTitle('My awesome rendered title') %}

For an advanced case you can combine view helpers together like:

    {% do form.setAttribute('action', ( url('/events/add') ) ) %}

### Extensions

The module adds two extension tags:
    
1. A tag for rendering a controller action:

    ```{% render "core-index:index" with {'param1':1} %}```
    
    The above code will call the `indexAction` from the `core-index` controller as defined in the ControllerLoader service.
    Optionally you can also specify different parameters to send to the processed action which can later be retrieved from the matched route.

2. A tag for triggering an event on the renderer that is similar to the above syntax:

    ```{% trigger "alias:myEvent" on myObject with {'param1':1} %}```
    
    Both the target object and parameters are optional. The result of each listener is converted to string and rendered instead of the definition. If the above alias is not specified then it will default to `zfc-twig`.
    
# Examples

Example .twig files for the skeleton application can be found in the
[examples](https://github.com/ZF-Commons/ZfcTwig/tree/master/examples) folder.