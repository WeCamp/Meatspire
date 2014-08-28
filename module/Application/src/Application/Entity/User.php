<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use ZfcUserDoctrineORM\Entity\User as ZfcUser;
use \Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @ORM\Table(name="user")
 * @ORM\Entity
 */

class User extends ZfcUser
{
    /**
     * @ORM\Column(name="bio", type="text", nullable=true)
     */
    protected $bio;

    /**
     * @ORM\OneToMany(targetEntity="GroupMember", mappedBy="user", cascade={"persist"})
     * @var ArrayCollection
     */
    protected $groupMemberships;

    public function __construct()
    {
        $this->groupMemberships = new ArrayCollection();
    }

    /**
     * Get Bio.
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set Bio.
     *
     * @param string $bio
     * @return UserInterface
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
        return $this;
    }

    /**
     * @param $groupMemberships
     */
    public function setGroupMemberships($groupMemberships)
    {
        $this->groupMemberships = $groupMemberships;
    }

    /**
     * @return ArrayCollection
     */
    public function getGroupMemberships()
    {
        return $this->groupMemberships;
    }
}
