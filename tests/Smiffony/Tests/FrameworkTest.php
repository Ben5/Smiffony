<?php

// framework/tests/Sinmplex/Tests/FrameworkTest.php

namespace Smiffony\Tests;

use Smiffony\Framework;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class FrameworkTest extends \PHPUnit_Framework_TestCase
{
    public function
    testNotFoundHandling()
    {
        $framework = $this->getFrameworkForException(new ResourceNotFoundException());

        $response = $framework->handle(new Request());

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function
    testErrorHandling()
    {
        echo 'ben';
        $framework = $this->getFrameworkForException(new \Exception());
        echo 'ben2';

        $response = $framework->handle(new Request());

        $this->assertEquals(500, $response->getStatusCode());
    }

    public function
    testControllerResponse()
    {
        $matcher = $this->getMock('Symfony\Component\Routing\Matcher\UrlMatcherInterface');
        $matcher
            ->expects($this->once())
            ->method('match')
            ->will($this->returnValue(array('_route'      => 'foo',
                                            'name'        => 'Ben',
                                            '_controller' => function ($name) { return new Response('Hello '.$name);} )));

        $resolver = new ControllerResolver();
        $framework = new Framework($matcher, $resolver);
        $response = $framework->handle(new Request());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hello Ben', $response->getContent());
    }

    protected function
    getFrameworkForException($exception)
    {
        $matcher = $this->getMock('Symfony\Component\Routing\Matcher\UrlMatcherInterface');
        $matcher
            ->expects($this->once())
            ->method('match')
            ->will($this->throwException($exception));
        $resolver = $this->getMock('Symfony\Component\HttpKernel\Controller\ControllerResolverInterface');

        return new Framework($matcher, $resolver);
    }
}
