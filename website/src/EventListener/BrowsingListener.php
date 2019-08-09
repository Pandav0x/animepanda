<?php

namespace App\EventListener;

use App\Entity\Tracking;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class BrowsingListener
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if (strpos(get_class($event->getController()[0]), 'App\\Controller') !== false) {
            $controllerName = str_replace('App\\Controller\\', '',
                get_class($event->getController()[0]) . '\\' . $event->getController()[1]);

            $tracking = new Tracking();
            $tracking->setIp($event->getRequest()->getClientIp());
            $tracking->setPage($event->getRequest()->getPathInfo());
            $tracking->setTimestamp(time());
            $tracking->setPostValues($event->getRequest()->get("tags"));

            $this->entityManager->persist($tracking);
            $this->entityManager->flush();
        }
    }
}