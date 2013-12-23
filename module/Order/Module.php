<?php

namespace Order;

use Order\Model\OrderTable;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Order\Model\OrderTable' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $table = new OrderTable($dbAdapter);
                        return $table;
                    },
                'Zend\Authentication\AuthenticationService' => function ($serviceManager) {
                        // If you are using DoctrineORMModule:
                        return $serviceManager->get('doctrine.authenticationservice.orm_default');
                    },
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}