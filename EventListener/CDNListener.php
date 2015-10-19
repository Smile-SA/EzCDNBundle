<?php

namespace EdgarEz\CDNBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CDNListener extends ContainerAware implements EventSubscriberInterface
{
    /**
     * Link Event with RESPONSE Kernel Event Dispatcher
     *
     * @return array list of event dispatcher linked
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => array('onResponse', 200)
        );
    }

    /**
     * Trigger event for RESPONSE Kervenel vent
     *
     * @param FilterResponseEvent $event event
     */
    public function onResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        if (!$event->isMasterRequest()) {
            return;
        }

        if ($request->isXmlHttpRequest()) {
            return;
        }

        if ($response->isRedirection()
            || ($response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html'))
            || 'html' !== $request->getRequestFormat()
        ) {
            return;
        }

        $configResolver = $this->container->get('ezpublish.config.resolver');
        $domain         = $configResolver->getParameter('domain', 'edgar_ez_cdn');
        $extensions     = $configResolver->getParameter('extensions', 'edgar_ez_cdn');

        if (empty($extensions))
            return;

        if (!is_array($extensions)) {
            $extensions = array($extensions);
        }

        if (count($extensions) == 0)
            return;

        $extensions = implode('|', $extensions);

        $content = $response->getContent();
        $pattern = '/="\/(var|bundles)\/(.*)\.(' . $extensions . ')([^"]*)"/i';
        $replace = '="http://' . $domain . '/${1}/${2}.${3}${4}"';

        $content = preg_replace($pattern, $replace, $content);

        $response->setContent($content);
    }

}