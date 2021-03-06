<?php


namespace Application\Controller;


use League\Tactician\CommandBus;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RegistrationControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if($serviceLocator instanceof AbstractPluginManager)
        {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var CommandBus $commandBus */
        $commandBus = $serviceLocator->get('commandBus');

        $instance = new RegistrationController();
        $instance->setCommandBus($commandBus);

        return $instance;
    }
}