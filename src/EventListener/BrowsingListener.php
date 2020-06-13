<?php

namespace App\EventListener;

use App\Entity\Tracking;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class BrowsingListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * BrowsingListener constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ControllerEvent  $event
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if(is_array($event->getController())) {
            $controller = $event->getController()[0];
        }

        if (strpos(get_class($controller), 'App\\Controller') !== false) {
            $tracking = new Tracking();
            $tracking->setIp($event->getRequest()->getClientIp());
            $tracking->setPage($event->getRequest()->getPathInfo());
            $tracking->setTimestamp(time());
            $tracking->setPostValues($event->getRequest()->get('tags'));

            $this->entityManager->persist($tracking);
            $this->entityManager->flush();
        }
    }
}