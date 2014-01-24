<?php

namespace ZfcTwig\View;

use Zend\View\HelperPluginManager as ZendHelperPluginManager;

class HelperPluginManager extends ZendHelperPluginManager
{
    /**
     * Default set of helpers factories
     *
     * @var array
     */
    protected $factories = array(
        'flashmessenger' => 'Zend\View\Helper\Service\FlashMessengerFactory',
    );

    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = array(
        'declarevars'      => 'Zend\View\Helper\DeclareVars',
        'htmlflash'        => 'Zend\View\Helper\HtmlFlash',
        'htmllist'         => 'Zend\View\Helper\HtmlList',
        'htmlobject'       => 'Zend\View\Helper\HtmlObject',
        'htmlpage'         => 'Zend\View\Helper\HtmlPage',
        'htmlquicktime'    => 'Zend\View\Helper\HtmlQuicktime',
        'layout'           => 'Zend\View\Helper\Layout',
        'renderchildmodel' => 'Zend\View\Helper\RenderChildModel',
    );
}
