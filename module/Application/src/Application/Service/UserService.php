<?php

namespace Application\Service;

use Application\Entity\Group;
use Application\Entity\User;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function isMemberOfGroup(User $user, Group $group)
    {
        return $user->getGroupMemberships()->matching(
            Criteria::create()->where(Criteria::expr()->eq('group', $group))
        )->count() > 0;
    }
}
