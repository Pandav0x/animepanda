<?php


namespace App\EventListener;


use Symfony\Component\HttpKernel\Event\RequestEvent;

class LocaleListener
{
    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $locale = $request->getLocale();

        $request->setLocale($locale);
    }
}