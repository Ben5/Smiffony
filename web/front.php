<?php

// framework/web/front.php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Reference;

$sc       = include __DIR__.'/../src/container.php';

// register custom listeners here:
$sc->register('listener.string_response', 'Smiffony\StringResponseListener');
$sc->getDefinition('dispatcher')
    ->addMethodCall('addSubscriber', array(new Reference('listener.string_response')));

// set up any config params in the dependency-injection container
$sc->setParameter('charset', 'UTF-8');
$sc->setParameter('routes', include __DIR__.'/../src/app.php');

$request  = Request::createFromGlobals();

$response = $sc->get('framework')->handle($request);
$response->send();
