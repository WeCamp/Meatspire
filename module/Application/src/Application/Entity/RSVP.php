<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RSVP
 * @package Application\Entity
 * @ORM\Entity
 * @ORM\Table(name="rsvp")
 */
class RSVP 
{
    const TYPE_COMING = 1;
    const TYPE_NOTCOMING = 2;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     * @var Event
     */
    protected $event;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * @var User
     */
    protected $user;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $rsvpType;

    /**
     * @param \Application\Entity\Event $event
     * @return self
     */
    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return \Application\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $rsvpType
     * @return self
     */
    public function setRsvpType($rsvpType)
    {
        $this->rsvpType = $rsvpType;
        return $this;
    }

    /**
     * @return int
     */
    public function getRsvpType()
    {
        return $this->rsvpType;
    }

    /**
     * @param \Application\Entity\User $user
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return \Application\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }


}
