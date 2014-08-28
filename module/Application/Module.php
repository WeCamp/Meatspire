<?php

namespace Application;

use Application\Form\EventForm;
use Application\Service\GroupService;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\Hydrator\ClassMethods;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $zfcServiceEvents = $e->getApplication()->getServiceManager()->get('zfcuser_user_service')->getEventManager();

        $em = $eventManager->getSharedManager();
        // To validate new field
        $em->attach('ZfcUser\Form\Register','init', function($e) {
                $filter = $e->getTarget();
                $filter->add(
                    array(
                        'name'       => 'bio',
                        'required'   => false,
                        'allowEmpty' => true,
                        'filters'    => array(array('name' => 'StringTrim')),
                        'type'       => 'Zend\Form\Element\Textarea',
                        'attributes' => array(
                            'cols' => 40,
                            'rows' => 10
                        ),
                        'options'    => array(
                            'label'  => 'Bio'
                        )
                    )
                );

            });

        // Store the field
        $zfcServiceEvents->attach('register', function($e) {
                $form = $e->getParam('form');
                $user = $e->getParam('user');
                $user->setBio( $form->get('bio')->getValue() );
            });


    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'Application\Service\Event' => function ($sm) {
                        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
                        return new \Application\Service\EventService($entityManager);
                    },
                'Application\Form\UserEdit' => function ($sm) {
                        $register_form = $sm->get('zfcuser_register_form');
                        $options = $register_form->getRegistrationOptions();

                        $form = new \Application\Form\UserEdit('user-edit', $options);
                        $form->setHydrator(new ClassMethods());

                        return $form;
                    },
                'Application\Service\Group' => function ($sm) {
                    $entityManager   = $sm->get('Doctrine\ORM\EntityManager');
                    $groupRepository = $entityManager
                        ->getRepository('Application\Entity\Group');
                    return new GroupService($groupRepository, $entityManager);
                },
                'Application\Form\Group' => function ($sm) {
                    $entityManager = $sm->get('Doctrine\ORM\EntityManager');
                    return new EventForm($entityManager);
                }
            ]
        ];
    }
}
