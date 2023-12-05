<?php
namespace Contact;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'contact' => [
                'type' => Literal::class,
                'priority' => 1,
                'options' => [
                    'route' => '/contact',
                    'defaults' => [
                        'action' => 'index',
                        'controller' => Controller\ContactController::class,
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'config' => [
                        'type' => Segment::class,
                        'priority' => 100,
                        'options' => [
                            'route' => '/config[/:action]',
                            'defaults' => [
                                'action' => 'index',
                                'controller' => Controller\ConfigController::class,
                            ],
                        ],
                    ],
                    'default' => [
                        'type' => Segment::class,
                        'priority' => -100,
                        'options' => [
                            'route' => '/[:action[/:uuid]]',
                            'defaults' => [
                                'action' => 'index',
                                'controller' => Controller\ContactController::class,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'acl' => [
        'EVERYONE' => [
            'contact/default' => [],
        ],
        'admin' => [
            'contact/config' => [],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ConfigController::class => Controller\Factory\ConfigControllerFactory::class,
            Controller\ContactController::class => Controller\Factory\ContactControllerFactory::class,
        ],
    ],
    'form_elements' => [
        'factories' => [
            Form\ContactForm::class => Form\Factory\ContactFormFactory::class,
        ],
    ],
    'navigation' => [
        'default' => [
            'contact' => [
                'label' => 'Contacts',
                'route' => 'contact/default',
                'class' => 'dropdown',
                'resource' => 'contact/default',
                'privilege' => 'menu',
                'order' => '20',
                'pages' => [
                    [
                        'label' => 'Dashboard',
                        'route' => 'contact/default',
                        'action' => 'dashboard',
                        'resource' => 'contact/default',
                        'privilege' => 'dashboard',
                    ],
                    [
                        'label' => 'Add New Contact',
                        'route' => 'contact/default',
                        'action' => 'create',
                        'resource' => 'contact/default',
                        'privilege' => 'create',
                    ],
                    [
                        'label' => 'List Contacts',
                        'route' => 'contact/default',
                        'action' => 'index',
                        'resource' => 'contact/default',
                        'privilege' => 'index',
                    ],
                ],
            ],
            'settings' => [
                'label' => 'Settings',
                'pages' => [
                    'contact' => [
                        'label'  => 'Contact Settings',
                        'route'  => 'contact/config',
                        'action' => 'index',
                        'resource' => 'contact/config',
                        'privilege' => 'menu',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'contact-model-adapter-config' => 'model-adapter-config',
        ],
        'factories' => [
            'contact-model-adapter' => Service\Factory\ContactModelAdapterFactory::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];