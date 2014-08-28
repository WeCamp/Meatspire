<?php

namespace Application\Controller;

use Application\Entity\Group;
use Application\Entity\GroupMember;
use Application\Service\GroupService;
use Application\Service\UserService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GroupController extends AbstractActionController
{
    public function indexAction()
    {
        /** @var \Application\Service\GroupService $groups */
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
                /** @var \Application\Service\GroupService $groupService */
                $groupService = $this->serviceLocator->get('Application\Service\Group');

                $identity = $this->zfcUserAuthentication()->getIdentity();

                $groupService->addUserToGroup($identity, $groupEntity, GroupMember::ADMIN);

                return $this->redirect()->toRoute('group');
            }
        }

        return new ViewModel(['groupForm' => $groupForm]);
    }

    public function viewAction()
    {
        $groupId = $this->params()->fromRoute('id');

        $group = $this->getGroupService()->getGroupById($groupId);

        $isMember = false;
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            $isMember = $this->getUserService()->isMemberOfGroup($this->zfcUserAuthentication()->getIdentity(), $group);
        }

        return new ViewModel(['group' => $group, 'isMember' => $isMember]);
    }

    public function joinAction()
    {
        $groupId = $this->params()->fromRoute('id');
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            $this->flashMessenger()->addErrorMessage('You have to be logged in to join a group');
            return $this->redirect()->toRoute('group/view', ['id' => $groupId]);
        }

        $group = $this->getGroupService()->getGroupById($groupId);
        $identity = $this->zfcUserAuthentication()->getIdentity();

        $this->getGroupService()->addUserToGroup($identity, $group, GroupMember::MEMBER);
        $this->flashMessenger()->addSuccessMessage(sprintf('You have joined the group: %s', $group->getName()));
        return $this->redirect()->toRoute('group/view', ['id' => $groupId]);
    }

    public function leaveAction()
    {
        $groupId = $this->params()->fromRoute('id');
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            $this->flashMessenger()->addErrorMessage('You have to be logged in to leave a group');
            return $this->redirect()->toRoute('group/view', ['id' => $groupId]);
        }

        $group = $this->getGroupService()->getGroupById($groupId);
        $identity = $this->zfcUserAuthentication()->getIdentity();

        $this->getGroupService()->removeUserFromGroup($identity, $group);
        $this->flashMessenger()->addSuccessMessage(sprintf('You have left the group: %s', $group->getName()));
        return $this->redirect()->toRoute('group/view', ['id' => $groupId]);
    }

    /**
     * @return GroupService
     */
    protected function getGroupService()
    {
        return $this->getServiceLocator()->get('Application\Service\Group');
    }

    /**
     * @return UserService
     */
    protected function getUserService()
    {
        return $this->getServiceLocator()->get('Application\Service\User');
    }
}
