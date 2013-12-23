<?php

namespace Car\Controller;

use Car\Entity\Car;
use Car\Form\CarForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Form\Element;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container as SessionContainer;
use Zend\View\Model\ViewModel;
use Doctrine\ORM;
use Zend\Mvc\Controller;
use Car\Form\CarFilter;

class CarController extends AbstractActionController
{
    protected $_dir = null;

    public function indexAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $dql = "SELECT u FROM Car\Entity\Car u";
        $query = $em->createQuery($dql);
        $cars = $query->getResult();
        return new ViewModel(array(
            'cars' => $cars
        ));
    }

    public function viewAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('car', array('action' => 'index'));
        }
        try {
            $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $dql = "SELECT u FROM Car\Entity\Car u WHERE u.id = $id";
            $query = $em->createQuery($dql);
            $car = $query->getResult();
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('car', array(
                'action' => 'index'
            ));
        }
        $_dir = $this->_dir;
        return array(
            'id' => $id,
            'car' => $car,
            '_dir' => $_dir,
        );
    }

    public function addAction()
    {
        $this->init();
        if (!is_dir($this->_dir)) {
            mkdir($this->_dir, 0777);
        }
        $entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $car = new Car;
        $form = new CarForm($this->_dir, 'CarForm');
        $form->get('submit')->setAttribute('value', 'Создать');
        $form->get('submit')->setAttribute('class', 'btn-success btn-large');
        $form->setHydrator(new DoctrineHydrator($entityManager, 'Car\Entity\Car'));
        $tempFile = null;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter(new CarFilter($this->getServiceLocator()));
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();
                    $this->setFileName($data);
                    $this->prepareData($car, $data);
                    $entityManager->persist($car);
                    $entityManager->flush();
                    return $this->redirect()->toRoute('car');
            }
        }
        return array(
            'form' => $form,
            'tempFile' => $tempFile);
    }

    public function init()
    {
        $config = $this->getServiceLocator()->get('Config');
        $fileManagerDir = $config['file_manager']['dir'];
        if ($user = $this->identity()) {

        } else {
            return $this->redirect()->toRoute('car');
        }
        $this->_dir = realpath($fileManagerDir) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'image_upload';
    }

    protected function setFileName($data)
    {
        if ($data['photo']['name']) {
        unset($data['submit']);
        rename($data['photo']['tmp_name'], $this->_dir . DIRECTORY_SEPARATOR . $data['photo']['name']);
        }
    }

    public function prepareData($car, $data)
    {
        $brand = $_REQUEST['brand'];
        $car->setBrand($brand);
        $name_model = $_REQUEST['name_model'];
        $car->setNameModel($name_model);
        $detail = $_REQUEST['detail'];
        $car->setDetail($detail);
        $photo = 'data/image_upload/' . $data['photo']['name'];
        $car->setPhoto($photo);
        return $car;
    }

    public function editAction()
    {
        $this->init();
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('car', array('action' => 'add'));
        }
        try {
            $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
            $dql = "SELECT u FROM Car\Entity\Car u WHERE u.id = $id";
            $query = $em->createQuery($dql);
            $car = $query->getResult();
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('car', array(
                'action' => 'index'
            ));
        }
        $entityManager = $this
            ->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $car2 = $entityManager->find('Car\Entity\Car', $id);

        $form = new CarForm($this->_dir, 'CarForm');
        $form->get('submit')->setAttribute('value', 'Изменить');
        $form->get('submit')->setAttribute('class', 'btn-success btn-large');
        $form->setHydrator(new DoctrineHydrator($entityManager,  get_class($car2)));
        $form->bind($car2);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $brand = $_REQUEST['brand'];
                $name_model = $_REQUEST['name_model'];
                $detail = $_REQUEST['detail'];
                $objectManager = $this
                    ->getServiceLocator()
                    ->get('Doctrine\ORM\EntityManager');
                $car = $objectManager->find('Car\Entity\Car', $id);
                if ($brand) {
                $car->setBrand($brand); }
                if ($name_model) {
                $car->setNameModel($name_model); }
                if ($detail) {
                $car->setDetail($detail); }
                $objectManager->persist($car);
                $objectManager->flush();
                return $this->redirect()->toRoute('car');
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
            'car' => $car,
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('car');
        }
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        try {
            $repository = $em->getRepository('Car\Entity\Car');
            $dql = "SELECT u FROM Car\Entity\Car u WHERE u.id=$id";
            $query = $em->createQuery($dql);
            $car = $query->getResult();
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('car', array(
                'action' => 'index'
            ));
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $objectManager = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');
            $car = $objectManager->find('Car\Entity\Car', $id);
            $objectManager->remove($car);
            $objectManager->flush();
            return $this->redirect()->toRoute('car');
        }

        return array(
            'id' => $id,
            'car' => $car,
        );
    }
}
