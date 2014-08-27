<?php

namespace Application\Entity;

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
     * @ORM\OneToMany(targetEntity="GroupMember", mappedBy="group")
     * @var GroupMember
     */
    protected $members;

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
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
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
     * @param GroupMember $members
     */
    public function setMembers($members)
    {
        $this->members = $members;
    }

    /**
     * @return GroupMember
     */
    public function getMembers()
    {
        return $this->members;
    }
}
