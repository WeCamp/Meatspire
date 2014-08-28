<?php

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcUser\View\Helper\ZfcUserIdentity;
use Zend\Http\PhpEnvironment;

class UserController extends AbstractActionController
{

    public function editAction()
    {

        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            $this->flashMessenger()->addErrorMessage('You have to be logged in to edit your profile');
            return $this->redirect()->toRoute('home');
        }

        /** @var \Application\Form\UserEdit $form */
        $form = $this->getServiceLocator()->get('Application\Form\UserEdit');

        /** @var ZfcUserIdentity $identity */
        $identity = $this->zfcUserAuthentication()->getIdentity();

        $form->bind($identity);
        $form->remove('username');
        $form->remove('password');
        $form->remove('passwordVerify');
        $form->remove('submit');

        $prg = $this->prg('/user/edit', true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return new ViewModel(array('userEdit' => $form));
        }

        $form->setData($prg);

            if ($form->isValid()) {

                /** @var EntityManager $entityManager */
                $entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

                $entityManager->persist($identity);
                $entityManager->flush();
                $form->setData($prg);
                $this->redirect('/user/edit');
            } else {
                var_dump($form->getMessages());
            }

        return new ViewModel(array('userEdit' => $form));
    }

}
