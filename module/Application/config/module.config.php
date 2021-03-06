<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use Application\Command\QueueRefreshCommand;
use Application\Command\QueueRefreshCommandHandler;
use Application\Command\RefreshCommandHandler;
use Application\Command\RegisterCommandHandler;
use Application\Command\RespondToWebHookCommand;
use Application\Command\RespondToWebHookCommandHandler;
use Application\CommandBus\CommandBusFactory;
use Application\Controller\ConsoleControllerFactory;
use Application\Controller\GitlabControllerFactory;
use Application\Controller\IndexControllerFactory;
use Application\Controller\RegistrationControllerFactory;
use Application\Model\CommitFileStatus;
use Application\Model\Commit;
use Application\Model\Mapper\CommitFileStatusMapper;
use Application\Model\Mapper\CommitMapper;
use Application\Model\Mapper\RepositoryMapper;
use Application\Model\Repository;
use Zend\Db\Adapter\AdapterAbstractServiceFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/application',
                    'defaults' => [
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/[:controller[/:action]][/:page]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '[0-9]*'
                            ],
                            'defaults' => [
                                'page' => 1
                            ],
                        ],
                    ],
                ],
            ],
            'log' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/log[/:page]',
                    'constraints' => [
                        'page' => '[0-9]*'
                    ],
                    'defaults' => [
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                        'page' => 1
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
            AdapterAbstractServiceFactory::class,
        ],
        'factories' => [
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
            'commandBus' => CommandBusFactory::class,
            RespondToWebHookCommandHandler::class => function ($sm){
                $instance = new RespondToWebHookCommandHandler();
                $instance->setCommandBus($sm->get('commandBus'));
                $instance->setRepositoryMapper($sm->get('repositoryMapper'));
                return $instance;
            },
            RefreshCommandHandler::class => function ($sm) {
                $instance = new RefreshCommandHandler;
                $instance->setRepositoryMapper($sm->get('repositoryMapper'));
                $instance->setCommitMapper($sm->get('CommitMapper'));
                return $instance;
            },
            RegisterCommandHandler::class => function ($sm) {
                $instance = new RegisterCommandHandler();
                $instance->setRepositoryMapper($sm->get('repositoryMapper'));
                return $instance;
            },
            'repositoryMapper' => function($sm) {
                $adapter = $sm->get('RepoDb');
                $mapper = new RepositoryMapper($adapter, 'repository', 'id', new Repository);
                return $mapper;
            },
            'commitMapper' => function($sm) {
                $adapter = $sm->get('RepoDb');
                $mapper = new CommitMapper($adapter, 'commit', 'commit_id', new Commit);
                $mapper->setCommitFileStatusMapper($sm->get('commitFileStatusMapper'));
                $mapper->setRepositoryMapper($sm->get('repositoryMapper'));
                return $mapper;
            },
            'commitFileStatusMapper' => function($sm) {
                $adapter = $sm->get('RepoDb');
                $mapper = new CommitFileStatusMapper($adapter, 'commit_file_status', 'commit_file_status_id', new CommitFileStatus);
                return $mapper;
            }
        ],
        'invokables' => [
            QueueRefreshCommandHandler::class => QueueRefreshCommandHandler::class,
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
        ],
        'factories' => [
            'Application\Controller\Index' => IndexControllerFactory::class,
            'Application\Controller\Gitlab' => GitlabControllerFactory::class,
            'Application\Controller\Console' => ConsoleControllerFactory::class,
            'Application\Controller\Registration' => RegistrationControllerFactory::class,
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // Placeholder for console routes
    'console' => [
        'router' => [
            'routes' => [
                'refresh' => [
                    'options' => [
                        'route'    => 'refresh <url>',
                        'defaults' => [
                            'controller' => 'Application\Controller\Console',
                            'action'     => 'refresh'
                        ]
                    ]
                ]
            ],
        ],
    ],
    'db' => [
        'adapters' => [
            'RepoDb' => [
                'driver' => 'Pdo_Sqlite',
                'database' => 'data/repo.sqlite'
            ]
        ]
    ],
    'migrations' => [
        'repo' => [
            'dir' => dirname(__FILE__) . '/../../../data/migrations/repo',
            'namespace' => 'Repo\Migrations',
            'adapter' => 'RepoDb'
        ],
    ]
];
