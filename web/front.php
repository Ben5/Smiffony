<?php

// framework/web/front.php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel;
use Symfony\Component\Routing;

$request  = Request::createFromGlobals();
$routes   = include __DIR__.'/../src/app.php';

$context  = new Routing\RequestContext();
$matcher  = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();

$dispatcher = new EventDispatcher();
// add a listener that populates request attributes with route parameters
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher));
// add a listener that handles exceptions in a nice way
$exceptionListener = new HttpKernel\EventListener\ExceptionListener('Calendar\\Controller\\ErrorController::exceptionAction');
$dispatcher->addSubscriber($exceptionListener);
// add a listener that prepares the Response before sending it out
$dispatcher->addSubscriber(new HttpKernel\EventListener\ResponseListener('UTF-8'));
// add a listener that allows controllers to return a string instead of a Response (the listener creates a Response from the string)
$dispatcher->addSubscriber(new Smiffony\StringResponseListener());

// now create the framework!
$framework = new Smiffony\Framework($dispatcher, $resolver);

// let the framework handle the request and generate (and send) a response
$response = $framework->handle($request);
$response->send();
