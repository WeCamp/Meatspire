<?php

namespace Application\Service;

use Application\Entity\Event;
use Application\Entity\Group;
use Application\Entity\GroupMember;
use Application\Entity\User;
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

    /**
     * @param int $id
     * @return Event
     */
    public function getEventById($id)
    {
        return $this->entityManager->getRepository('Application\Entity\Event')->find($id);
    }

    /**
     * @param User $user
     * @param Group $group
     * @param $role
     */
    public function addUserToGroup(User $user, Group $group, $role)
    {
        $groupMember = new GroupMember();
        $groupMember->setUser($user);
        $groupMember->setGroup($group);
        $groupMember->setRole($role);

        $group->getMembers()->add($groupMember);
    }

    public function saveGroup(Group $group)
    {
        $this->entityManager->persist($group);
        $this->entityManager->flush($group);
    }
}
