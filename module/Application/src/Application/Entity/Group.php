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
     * @param \Application\Entity\User $organizer
     */
    public function setOrganizer($organizer)
    {
        $this->organizer = $organizer;
    }

    /**
     * @return \Application\Entity\User
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

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
     * @ORM\ManyToMany(targetEntity="User")
     * @var User
     */
    protected $organizer;
}
