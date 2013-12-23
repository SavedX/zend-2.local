<?php
namespace AuthDoctrine;

return array(
    'controllers' => array(
        'invokables' => array(
            'AuthDoctrine\Controller\Index' => 'AuthDoctrine\Controller\IndexController',
            'AuthDoctrine\Controller\Registration' => 'AuthDoctrine\Controller\RegistrationController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'auth-doctrine' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/auth-doctrine',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AuthDoctrine\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'auth-doctrine' => __DIR__ . '/../view'
        ),

        'display_exceptions' => true,
    ),
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'AuthDoctrine\Entity\User',
                'identity_property' => 'usrName',
                'credential_property' => 'usrPassword',
                'credential_callable' => function (Entity\User $user, $passwordGiven) {
                        // return my_awesome_check_test($user->getPassword(), $passwordGiven);
                        // echo '<h1>callback user->getPassword = ' .$user->getPassword() . ' passwordGiven = ' . $passwordGiven . '</h1>';
                        //- if ($user->getPassword() == md5($passwordGiven)) { // original
                        if (
                            $passwordGiven == $user->getUsrPassword() &&
//                        $user->getUsrPassword() == md5('aFGQ475SDsdfsaf2342' . $passwordGiven . $user->getUsrPasswordSalt()) &&
                            $user->getUsrActive() == 1
                        ) {
                            return true;
                        } else {
                            return false;
                        }
                    },
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
);