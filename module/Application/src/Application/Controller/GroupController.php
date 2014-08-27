<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\Group;
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
            'locations' => $groups->getUniqueLocations()
        ]);
    }

    public function createAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            $this->flashMessenger()->addErrorMessage('You have to be logged in to create an account');
            return $this->redirect()->toRoute('home');
        }

        /** @var \Zend\Form\Form $groupEntity */
        $groupForm = $this->getServiceLocator()->get('Application\Form\Group');
        $groupEntity = new Group();
        $groupForm->bind($groupEntity);

        if ($this->getRequest()->isPost()) {
            $groupForm->setData($this->getRequest()->getPost());
            if ($groupForm->isValid()) {
                $entityManager = $this->getServiceLocator()
                    ->get('Doctrine\ORM\EntityManager');
                $entityManager->persist($groupEntity);
                $entityManager->flush();
                return $this->redirect()->toRoute('group');
            }
        }

        return new ViewModel(['groupForm' => $groupForm]);
    }
}
