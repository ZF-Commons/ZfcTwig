<?php
namespace ZfcTwigTest\View\Strategy;

use PHPUnit_Framework_TestCase as TestCase;
use Twig_Environment;
use Twig_Loader_Array;
use Zend\View\View;
use Zend\View\ViewEvent;
use ZfcTwig\View\Renderer\TwigRenderer;
use ZfcTwig\View\Strategy\TwigStrategy;
use ZfcTwig\View\Resolver\TwigResolver;

class TwigStrategyTest extends TestCase
{
    public function setUp()
    {
        $this->environment = new Twig_Environment(new Twig_Loader_Array(array('key1' => 'var1')));
        $this->renderer = new TwigRenderer(new View, $this->environment, new TwigResolver($this->environment));
        $this->strategy = new TwigStrategy($this->renderer);
        $this->event    = new ViewEvent();
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
