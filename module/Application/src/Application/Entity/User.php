<?php

namespace Application\Entity;

use ZfcUser;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */

class User extends ZfcUser\Entity\User implements ZfcUser\Entity\UserInterface
{

}
