<?php
namespace ZfcTwigTest\View\Strategy;

use PHPUnit_Framework_TestCase as TestCase;
use Twig_Environment;
use Twig_Loader_Array;
use Twig_Loader_Chain;
use Zend\View\View;
use Zend\View\ViewEvent;
use ZfcTwig\View\TwigRenderer;
use ZfcTwig\View\TwigStrategy;
use ZfcTwig\View\TwigResolver;

class TwigStrategyTest extends TestCase
{
    public function setUp()
    {
        $this->chain  = $chain = new Twig_Loader_Chain();
        $this->loader = new Twig_Loader_Array(array('key1' => 'var1'));
        $this->chain->addLoader($this->loader);
        $this->environment = new Twig_Environment($this->chain);
        $this->renderer    = new TwigRenderer(new View, $this->chain, $this->environment, new TwigResolver($this->environment));
        $this->strategy    = new TwigStrategy($this->renderer);
        $this->event       = new ViewEvent();
    }

    public function testSelectRendererWhenTemplateFound()
    {
        $model = $this->getMock('Zend\View\Model\ModelInterface');
        $model->expects($this->at(0))
              ->method('getTemplate')
              ->will($this->returnValue('key1'));

        $event = new ViewEvent;
        $event->setModel($model);

        $result = $this->strategy->selectRenderer($event);
        $this->assertSame($this->renderer, $result);
    }
}
