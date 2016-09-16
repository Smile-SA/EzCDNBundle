<?php

namespace Smile\EzCDNBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CDNListener implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    private $extensions;

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    public function setExtensions(array $extensions)
    {
        $this->extensions = $extensions;
    }

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

        $http = $request->isSecure() ? 'https' : 'http';

        if (empty($this->extensions))
            return;

        if (count($this->extensions) == 0)
            return;

        $extensions = implode('|', $this->extensions);

        $content = $response->getContent();
        $pattern = '/="[^"]*\/(css|js|var|bundles)\/(.*)\.(' . $extensions . ')([^"]*)"/i';
        $replace = '="' . $http . '://' . $this->domain . '/${1}/${2}.${3}${4}"';

        $content = preg_replace($pattern, $replace, $content);

        $response->setContent($content);
    }

}
