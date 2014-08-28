<?php

namespace Application\Service;

use Application\Entity\GroupMember;
use Application\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class Group
{
    protected $groupRepository;
    protected $entityManager;

    public function __construct(EntityRepository $repository, EntityManager $entityManager)
    {
        $this->groupRepository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param $filters
     * @return array
     */
    public function getGroupsOverview($filters)
    {
        return $this->groupRepository->findBy($filters);
    }

    public function getUniqueLocations()
    {
        $query = $this->entityManager->createQuery(
            'SELECT DISTINCT g.location FROM Application\Entity\Group g ORDER BY g.location ASC'
        );
        return $query->getResult();
    }

    /**
     * @param User $user
     * @param \Application\Entity\Group $group
     * @param int $role
     */
    public function addUserToGroup(User $user, \Application\Entity\Group $group, $role)
    {
        $groupMember = new GroupMember();
        $groupMember->setUser($user);
        $groupMember->setGroup($group);
        $groupMember->setRole($role);

        $group->getMembers()->add($groupMember);
    }

    /**
     * @param \Application\Entity\Group $group
     */
    public function saveGroup(\Application\Entity\Group $group)
    {
        $this->entityManager->persist($group);
        $this->entityManager->flush($group);
    }
}
