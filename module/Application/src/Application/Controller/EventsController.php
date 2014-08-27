<?php

namespace Application\Controller;

use Application\Entity\Event;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EventsController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function createAction()
    {
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
