<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class GroupMember
 * @package Application\Entity
 * @ORM\Entity
 * @ORM\Table(name="group_member")
 */
class GroupMember
{
    const MEMBER = 1;
    const ADMIN = 2;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="group_member_id", type="integer", nullable=false)
     * @var int
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="groups", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * @var User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="members", cascade={"persist"})
     * @ORM\JoinColumn(name="group_id", referencedColumnName="group_id")
     * @var Group
     */
    protected $group;

    /**
     * @ORM\Column(name="role", type="integer")
     * @var int
     */
    protected $role;

    /**
     * @param Group $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
