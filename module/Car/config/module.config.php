<?php
namespace Car;
return array(
    'controllers' => array(
        'invokables' => array(
            'Car\Controller\Car' => 'Car\Controller\CarController',
        ),
    ),
    'doctrine' => array(
        'car' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Car\Entity\Car',
            ),
        ),
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                )
            )
        )
    ),

    'router' => array(
        'routes' => array(
            'car' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/car[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Car\Controller\Car',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'car' => __DIR__ . '/../view',
        ),
    ),
);