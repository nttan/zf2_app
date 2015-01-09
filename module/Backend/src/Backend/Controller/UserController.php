<?php

namespace Backend\Controller;

use Application\Entity\User;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function insertAction()
    {

        $objectManager = $this
            ->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $user = new User();
        $user->setFullName('Tan Nguyen');
        $user->setEmail('tan@gmail.com');

        $objectManager->persist($user);
        $objectManager->flush();

        die(var_dump($user->getId()));
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }

    public function updateAction()
    {
        $user_id = $this->params()->fromRoute('id');
        $em = $this->getEntityManager();
        $user = $em->getRepository('Application\Entity\User')->find($user_id);
        if ($user) {
            $user->setEmail('tan@gmail.com');
            $objectManager = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
            $objectManager->persist($user);
            $objectManager->flush();
        }
        return $this->redirect()->toRoute('admin/default', array('controller' => 'user', 'action' => 'list'));

    }

    public function listAction()
    {
        $em = $this->getEntityManager();
        $users = $em->getRepository('Application\Entity\User')->findAll();
        return new ViewModel(array('users' => $users));
    }


    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
}

