<?php

namespace Application\Service;

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
}
