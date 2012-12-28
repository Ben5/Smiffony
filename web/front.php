<?php

// framework/web/front.php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\HttpKernel\HttpCache\Esi;
use Symfony\Component\Routing;
use Symfony\Component\EventDispatcher\EventDispatcher;


$request = Request::createFromGlobals();
$routes  = include __DIR__.'/../src/app.php';

$dispatcher = new EventDispatcher();

$dispatcher->addSubscriber(new Smiffony\ContentLengthListener());
$dispatcher->addSubscriber(new Smiffony\GoogleListener());

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new ControllerResolver();

$framework = new Smiffony\Framework($matcher, $resolver, $dispatcher);
$framework = new HttpCache($framework, new Store(__DIR__.'/../cache'), new Esi());

$response = $framework->handle($request);
$response->send();
