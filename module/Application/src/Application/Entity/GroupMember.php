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
}
