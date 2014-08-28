<?php

namespace Application\Controller;

use Application\Entity\Event;
use Application\Entity\GroupMember;
use Application\Entity\User;
use Application\Form\EventForm;
use Application\Service\EventService;
use Doctrine\Common\Collections\Criteria;
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

        /** @var User $identity */
        $identity = $this->zfcUserAuthentication()->getIdentity();

        /** @var EventForm $eventForm */
        $eventForm = $this->getServiceLocator()->get('Application\Form\Event');

        $groups = [];

        /** @var GroupMember[] $groupMemberships */
        $groupMemberships = $identity->getGroupMemberships()
            ->matching(Criteria::create()->where(Criteria::expr()->eq('role', GroupMember::ADMIN)));

        foreach ($groupMemberships as $groupMembership) {
            $groups[$groupMembership->getGroup()->getId()] = $groupMembership->getGroup()->getName();
        }

        $eventForm->setGroups($groups);

        $eventEntity = new Event();
        $eventForm->bind($eventEntity);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $eventForm->setData($data);
            if ($eventForm->isValid()) {
                /** @var \Application\Service\EventService $eventService */
                $eventService = $this->getServiceLocator()->get('Application\Service\Event');

                if (!empty($data['group_id'])) {
                    /** @var \Application\Service\GroupService $groupService */
                    $groupService = $this->getServiceLocator()->get('Application\Service\Group');

                    $eventEntity->setGroup($groupService->getGroup($data['group_id']));
                }

                $eventService->saveEvent($eventEntity);

                return $this->redirect()->toRoute('event');
            }
        }

        return new ViewModel(['eventForm' => $eventForm]);
    }

    public function viewAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');

        /** @var EventService $eventService */
        $eventService = $this->getServiceLocator()->get('Application\Service\Event');
        $event = $eventService->getEventById($id);

        return new ViewModel(['event' => $event]);
    }
}
