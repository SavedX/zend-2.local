<?php

namespace Order\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Order\Entity\Order;
use Order\Form\OrderForm;
use Zend\Form\Element;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Order\Form\OrderFilter;

class OrderController extends AbstractActionController
{

    public function indexAction()
    {
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $dql = "SELECT u FROM Order\Entity\Order u";
        $query = $entityManager->createQuery($dql);
        $orders = $query->getResult();
        return new ViewModel(array(
            'orders' => $orders,
        ));
    }

    public function buyAction()
    {
        $car_id = (int)$this->params('id');
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $order = new Order;
        $form = new OrderForm($car_id);
        $form->get('submit')->setAttribute('value', 'Создать');
        $form->get('submit')->setAttribute('class', 'btn-success btn-large');
        $form->setHydrator(new DoctrineHydrator($entityManager, 'Order\Entity\Order'));

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new OrderFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->prepareData($order);
                $entityManager->persist($order);
                $entityManager->flush();

                return $this->redirect()->toRoute('car');
            }
        }
        return array(
            'form' => $form,
            'car_id' => $car_id,
        );
    }

    public function prepareData($order)
    {
        $first_name = $_REQUEST['first_name'];
        $order->setFirstName($first_name);
        $second_name = $_REQUEST['second_name'];
        $order->setSecondName($second_name);
        $email = $_REQUEST['email'];
        $order->setEmail($email);
        $city = $_REQUEST['city'];
        $order->setCity($city);
        $phone = $_REQUEST['phone'];
        $order->setPhone($phone);
        $order->setIsRead(0);
        $car_id = $_REQUEST['car_id'];
        $order->setCarId($car_id);
        return $order;
    }

    public function viewAction()
    {
        $id = (int)$this->params('id'); // order id
        if (!$id) {
            return $this->redirect()->toRoute('order', array('action' => 'index'));
        }
        try {
            $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $dql = "SELECT o FROM Order\Entity\Order o JOIN Car\Entity\Car c WHERE o.car_id = c.id AND o.id = $id";
            $query = $em->createQuery($dql);
            $orders = $query->getResult();

            $dql = "UPDATE Order\Entity\Order u SET u.is_read=1 WHERE u.id=$id";
            $query = $em->createQuery($dql);
            $order = $query->getResult();
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('car', array(
                'action' => 'index'
            ));
        }
        return array(
            'id' => $id,
            'orders' => $orders
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('order');
        }
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        try {
            $repository = $em->getRepository('Order\Entity\Order');
            $dql = "SELECT u FROM Order\Entity\Order u WHERE u.id=$id";
            $query = $em->createQuery($dql);
            $order = $query->getResult();
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('order', array(
                'action' => 'index'
            ));
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $objectManager = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
            $order = $objectManager->find('Order\Entity\Order', $id);
            $objectManager->remove($order);
            $objectManager->flush();
            return $this->redirect()->toRoute('order');
        }

        return array(
            'id' => $id,
            'order' => $order,
        );
    }
}
