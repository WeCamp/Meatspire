<?php

namespace Application\Controller;

use Application\Entity\Event;
use Application\Entity\RSVP;
use Application\InputFilter\RSVPFilter;
use Application\Service\EventService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
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
                $entityManager = $this->getEntityManager();
                $entityManager->persist($eventEntity);
                $entityManager->flush();
                return $this->redirect()->toRoute('event');
            }
        }

        return new ViewModel(['eventForm' => $eventForm]);
    }

    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');
        $eventService = $this->getEventService();
        $event = $eventService->getEventById($id);
        $user = $this->zfcUserAuthentication()->getIdentity();
        $rsvp = $eventService->getRsvpForUserAndEvent($user, $event);

        return new ViewModel(['event' => $event, 'rsvp' => $rsvp]);
    }

    public function rsvpAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('zfcuser/login');
        }

        $eventId  = $this->params()->fromRoute('id');
        $rsvpType = $this->params()->fromRoute('rsvp');
        $identity = $this->zfcUserAuthentication()->getIdentity();

        $inputFilter = new RSVPFilter();
        $inputFilter->setData(['rsvptype' => $rsvpType]);
        if (!$inputFilter->isValid()) {
            $this->flashMessenger()->addErrorMessage('Invalid RSVP type given');
        }

        /** @var EntityManager $entityManager */
        /** @var EntityRepository $eventRepository */
        $entityManager = $this->getEntityManager();
        $eventRepository = $entityManager->getRepository('Application\Entity\Event');
        $event = $eventRepository->find($eventId);
        $eventService = $this->getEventService();

        if (! $eventService->rsvpUserForEvent($identity, $event, $rsvpType)) {
            $this->flashMessenger()->addErrorMessage('There was an unkown problem with your RSVP.');
        }

        if ($rsvpType == RSVP::TYPE_COMING) {
            $this->flashMessenger()->addSuccessMessage(sprintf('Great, See you at %s!', $event->getTitle()));
        } else {
            $this->flashMessenger()->addSuccessMessage(sprintf('Good to let people know you\'re not coming to %s!', $event->getTitle()));
        }

        return $this->redirect()->toRoute('event/view', ['id' => $eventId]);
    }

    /**
     * @return array|object
     */
    protected function getEntityManager()
    {
        return $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
    }

    /**
     * @return EventService
     */
    protected function getEventService()
    {
        /** @var EventService $eventService */
        $eventService = $this->getServiceLocator()->get('Application\Service\Event');
        return $eventService;
    }
}
