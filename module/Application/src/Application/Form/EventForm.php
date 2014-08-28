<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;

class EventForm extends Form
{
    public function __construct()
    {
        parent::__construct('event');

        $this->setPreferFormInputFilter(true);
        $this->setAttribute('role', 'form');
        $this->setAttribute('class', 'form-horizontal');

        $this->add([
            'name' => 'title',
            'options' => [
                'label' => 'Title'
            ],
            'attributes' => [
                'type' => 'text'
            ]
        ]);

        $this->add([
            'name' => 'location',
            'options' => [
                'label' => 'Location'
            ],
            'attributes' => [
                'type' => 'text'
            ]
        ]);

        $this->add([
            'name' => 'description',
            'options' => [
                'label' => 'Description'
            ],
            'attributes' => [
                'type' => 'text'
            ]
        ]);

        $this->add([
            'name' => 'maxattendees',
            'options' => [
                'label' => 'Max. attendees'
            ],
            'attributes' => [
                'type' => 'number'
            ]
        ]);

        $this->add([
            'name' => 'group_id',
            'type' => 'select',
            'options' => [
                'label' => 'Group',
            ],
            'attributes' => [
                'type' => 'select',
            ],
        ]);

        $this->add([
            'name' => 'datetime',
            'options' => [
                'label' => 'Date and time'
            ],
            'attributes' => [
                'type' => 'datetime'
            ]
        ]);

        $this->setHydrator(new ClassMethods());

        $inputFilter = new InputFilter();
        $inputFilter->add([
            'name' => 'title',
            'required' => true,
            'validators' => [
                ['name' => 'not_empty']
            ],
            'filters' => [
                ['name' => 'StringTrim']
            ]
        ]);
        $this->setInputFilter($this->getInputFilter());

        $this->getInputFilter()->get('group_id')->setRequired(false);
    }

    public function setGroups(array $groups, $addEmpty = true)
    {
        $options = [
            'value_options' => $groups,
        ];

        if ($addEmpty === true) {
            $options['empty_option'] = 'Please select the organizing group...';
        }

        $this->get('group_id')->setOptions($options);
    }
}
