<?php

// framework/src/Smiffony/framework.php

namespace Smiffony;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Framework implements HttpKernelInterface
{
    protected $matcher;
    protected $resolver;
    protected $dispatcher;

    public function
    __construct(
        UrlMatcherInterface $matcher,
        ControllerResolverInterface $resolver,
        EventDispatcher $dispatcher )
    {
        $this->matcher    = $matcher;
        $this->resolver   = $resolver;
        $this->dispatcher = $dispatcher;
    }

    public function
    handle( 
        Request $request,
        $type = HttpKernelInterface::MASTER_REQUEST, 
        $catch = true)
    {
        try
        {
            $request->attributes->add( $this->matcher->match($request->getPathInfo()) );

            $controller = $this->resolver->getController($request);
            $arguments  = $this->resolver->getArguments($request, $controller);

            $response = call_user_func_array($controller, $arguments);
        }
        catch (ResourceNotFoundException $e)
        {
            $response = new Response('Not Found', 404);
        }
        catch (\Exception $e)
        {
            $response = new Response('An error occured: '.print_r($e), 500);
        }

        // dispatch a response event
        $this->dispatcher->dispatch('response', new ResponseEvent($response, $request));

        return $response;
    }
}

