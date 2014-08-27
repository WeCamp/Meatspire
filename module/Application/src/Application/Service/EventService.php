<?php

namespace Application\Service;

use Doctrine\ORM\EntityManager;

/**
 * Class EventService
 * @package Application\Service
 */
class EventService
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->entityManager->getRepository('Application\Entity\Event')->findAll();
    }
}
