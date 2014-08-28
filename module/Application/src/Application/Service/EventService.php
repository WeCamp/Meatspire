<?php

namespace Application\Service;

use Application\Entity\Event;
use Application\Entity\RSVP;
use Doctrine\ORM\EntityManager;
use ZfcUser\Entity\User;

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
        return $this->entityManager->getRepository('Application\Entity\Event')->findBy([], ['datetime' => 'DESC']);
    }

    /**
     * @param int $id
     * @return Event
     */
    public function getEventById($id)
    {
        return $this->entityManager->getRepository('Application\Entity\Event')->find($id);
    }

    /**
     * @param $user User
     * @param $event Event
     * @param $rsvpType
     * @return boolean
     */
    public function rsvpUserForEvent(User $user, Event $event, $rsvpType)
    {
        $rsvp = new RSVP();
        $rsvp->setUser($user);
        $rsvp->setEvent($event);
        $rsvp->setRsvpType($rsvpType);
        $this->entityManager->persist($rsvp);

        try {
            $this->entityManager->flush();
            return true;
        } catch (\Exception $caught) {
            return false;
        }
    }

    /**
     * @param User $user
     * @param Event $event
     * @return null|object
     */
    public function getRsvpForEventByUser(User $user, Event $event)
    {
        $entityRepository = $this->entityManager->getRepository('Application\Entity\RSVP');
        $rsvp = $entityRepository->findOneBy(['event' => $event->getId(), 'user' => $user->getId()]);
        return $rsvp;
    }
    /**
     * @param Event $event
     */
    public function saveEvent(Event $event)
    {
        $this->entityManager->persist($event);
        $this->entityManager->flush($event);
    }
}
