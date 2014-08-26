<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Group
 * @package Application\Entity
 * @ORM\Entity
 * @ORM\Table(name="group")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(name="description", type="string", nullable=true)
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(name="image", type="string", nullable=true)
     * @var string
     */
    protected $image;

    /**
     * @ORM\Column(name="location", type="string", nullable=true)
     * @var string
     */
    protected $location;

    /**
     * @ManyToMany(targetEntity="Group", inversedBy="users")
     * @var User
     */
    protected $organizer;
}
