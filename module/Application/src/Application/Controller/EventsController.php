<?php

namespace Application\Controller;

use Application\Entity\Event;
use Application\Service\EventService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EventsController extends AbstractActionController
{
    public function indexAction()
    {
        /** @var EventService $eventService */
        $eventService = $this->getServiceLocator()->get('Application\Service\Event');

        $events = $eventService->getEvents();

        return new ViewModel(['events' => $events]);
    }

    public function createAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            $this->flashMessenger()->addErrorMessage('You have to be logged in to create an event.');
            return $this->redirect()->toRoute('home');
        }

        /** @var \Zend\Form\Form $eventForm */
        $eventForm = $this->getServiceLocator()->get('Application\Form\Event');
        $eventEntity = new Event();
        $eventForm->bind($eventEntity);

        if ($this->getRequest()->isPost()) {
            $eventForm->setData($this->getRequest()->getPost());
            if ($eventForm->isValid()) {
                $entityManager = $this->getServiceLocator()
                    ->get('Doctrine\ORM\EntityManager');
                $entityManager->persist($eventEntity);
                $entityManager->flush();
                return $this->redirect()->toRoute('event');
            }
        }

        return new ViewModel(['eventForm' => $eventForm]);
    }
}
