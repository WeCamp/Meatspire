<?php

namespace Application\InputFilter;

use Application\Entity\RSVP;
use Zend\InputFilter\InputFilter;

class RSVPFilter extends InputFilter
{
    public function __construct()
    {
        $this->add([
            'name' => 'rsvptype',
            'validators' => [
                ['name' => 'InArray', 'options' => ['haystack' => [RSVP::TYPE_COMING, RSVP::TYPE_NOTCOMING]]]
            ]
        ]);
    }

}
