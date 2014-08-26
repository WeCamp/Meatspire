<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class EventFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new Form('create-event');
        $form->setAttribute('role', 'form');

        $form->add([
            'name' => 'title',
            'options' => [
                'label' => 'Title'
            ],
            'attributes' => [
                'type' => 'text'
            ]
        ]);

        $form->add([
            'name' => 'location',
            'options' => [
                'label' => 'Location'
            ],
            'attributes' => [
                'type' => 'text'
            ]
        ]);

        $form->add([
            'name' => 'description',
            'options' => [
                'label' => 'Description'
            ],
            'attributes' => [
                'type' => 'text'
            ]
        ]);

        $form->add([
            'name' => 'maxattendees',
            'options' => [
                'label' => 'Max. attendees'
            ],
            'attributes' => [
                'type' => 'number'
            ]
        ]);

        $form->add([
            'name' => 'datetime',
            'options' => [
                'label' => 'Date and time'
            ],
            'attributes' => [
                'type' => 'number'
            ]
        ]);

        $form->setHydrator(new ClassMethods());

        return $form;
    }
}
