<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class GroupFormFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new Form();

        $form->add([
            'name' => 'name',
            'options' => [
                'label' => 'Name',
            ],
            'attributes' => [
                'type' => 'text',
            ],
        ]);

        $form->add([
            'name' => 'description',
            'options' => [
                'label' => 'Description',
            ],
            'attributes' => [
                'type' => 'textarea',
            ],
        ]);

        $form->add([
            'name' => 'location',
            'options' => [
                'label' => 'Location',
            ],
            'attributes' => [
                'type' => 'text',
            ],
        ]);

        $form->setHydrator(new ClassMethods());
        $form->setInputFilter($this->getInputFilter());

        return $form;
    }

    protected function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $inputFilter->add([
            'name' => 'name',
            'required' => true,
            'validators' => [
                ['name' => 'not_empty']
            ],
            'filters' => [
                ['name' => 'StringTrim']
            ]
        ]);
        return $inputFilter;
    }
}
