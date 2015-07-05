<?php


namespace Application\Controller;


use Application\Model\Mapper\CommitMapper;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
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

        /** @var CommitMapper $mapper */
        $mapper = $serviceLocator->get('commitMapper');

        $instance = new IndexController();
        $instance->setCommitMapper($mapper);
        return $instance;
    }
}