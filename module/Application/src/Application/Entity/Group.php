<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Group
 * @package Application\Entity
 * @ORM\Entity
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="group_id", type="integer", nullable=false)
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
     * @ORM\Column(name="location", type="string", nullable=true)
     * @var string
     */
    protected $location;

    /**
     * @ORM\OneToMany(targetEntity="GroupMember", mappedBy="group")
     * @var ArrayCollection
     */
    protected $members;

    /**
     *
     */
    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param ArrayCollection|array $members
     */
    public function setMembers($members)
    {
        if (is_array($members)) {
            $members = new ArrayCollection($members);
        }
        $this->members = $members;
    }

    /**
     * @return ArrayCollection
     */
    public function getMembers()
    {
        return $this->members;
    }
}
