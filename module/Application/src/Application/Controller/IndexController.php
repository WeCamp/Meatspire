<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        /** @var EventService $eventService */
        $eventService = $this->getServiceLocator()->get('Application\Service\Event');

        $events = $eventService->getEvents();

        return new ViewModel(['events' => $events]);
    }
}
