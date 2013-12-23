<?php

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'absoluteUrl' => function ($sm) {
                        $entityManager = $sm->getServiceLocator()->get('doctrine.entitymanager.orm_default');
                        $dql = "SELECT o FROM Order\Entity\Order o WHERE o.is_read = 0";
                        $query = $entityManager->createQuery($dql);
                        $orders = $query->getResult();
                        $ordersCount = count($orders);
                        $locator = $sm->getServiceLocator();

                        return new \Application\View\Helper\OrdersCount($locator->get('Request'), array('ordersCount' => $ordersCount));
                    },
            ),
        );
    }
}
