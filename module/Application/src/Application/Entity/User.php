<?php

namespace Application\Entity;

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

}
