<?php

// framework/src/Smiffony/GoogleListener.php

namespace Smiffony;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GoogleListener implements EventSubscriberInterface
{
    public static function
    getSubscribedEvents()
    {
        return array('response' => 'onResponse');
    }

    public function
    onResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();

        if($response->isRedirection()
            || ($response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html'))
            || 'html' !== $event->getRequest()->getRequestFormat() )
        {
            return;
        }

        $response->setContent( $response->getContent().'<br><br>Powered by Ben' );
    }
}
