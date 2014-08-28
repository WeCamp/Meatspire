<?php

namespace Application;

use Application\Service\Group;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

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
                $element = $filter->add(
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

                $user->setUsername( $form->get('username')->getValue() );
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
                'Application\Service\Group' => function ($sm) {
                    $entityManager   = $sm->get('Doctrine\ORM\EntityManager');
                    $groupRepository = $entityManager
                        ->getRepository('Application\Entity\Group');
                    return new Group($groupRepository, $entityManager);
                }
            ]
        ];
    }
}
