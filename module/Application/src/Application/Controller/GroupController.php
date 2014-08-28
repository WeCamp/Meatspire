<?php

namespace Application\Controller;

use Application\Entity\Group;
use Application\Entity\GroupMember;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GroupController extends AbstractActionController
{
    public function indexAction()
    {
        /** @var \Application\Service\Group $groups */
        $groups = $this->getServiceLocator()->get('Application\Service\Group');

        $filters = [];
        $location = $this->params()->fromQuery('location');
        if ($location) {
            $filters['location'] = $location;
        }

        return new ViewModel([
            'groups'    => $groups->getGroupsOverview($filters),
            'locations' => $groups->getUniqueLocations(),
            'filters' => $filters
        ]);
    }

    public function createAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            $this->flashMessenger()->addErrorMessage('You have to be logged in to create a group');
            return $this->redirect()->toRoute('home');
        }

        /** @var \Zend\Form\Form $groupForm */
        $groupForm = $this->getServiceLocator()->get('Application\Form\Group');
        $groupEntity = new Group();
        $groupForm->bind($groupEntity);

        if ($this->getRequest()->isPost()) {
            $groupForm->setData($this->getRequest()->getPost());
            if ($groupForm->isValid()) {
                /** @var \Application\Service\EventService $eventService */
                $eventService = $this->serviceLocator->get('Application\Service\Event');

                $identity = $this->zfcUserAuthentication()->getIdentity();

                $eventService->addUserToGroup($identity, $groupEntity, GroupMember::ADMIN);

                $eventService->saveGroup($groupEntity);

                return $this->redirect()->toRoute('group');
            }
        }

        return new ViewModel(['groupForm' => $groupForm]);
    }
}
