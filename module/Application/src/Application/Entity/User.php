<?php

namespace Application\Entity;

use ZfcUser;

use Doctrine\ORM\Mapping as ORM;

class User extends ZfcUser\Entity\User implements ZfcUser\Entity\UserInterface
{

}
