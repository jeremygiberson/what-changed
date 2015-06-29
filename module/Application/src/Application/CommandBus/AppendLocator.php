<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/29/15 3:20 PM
 */

namespace Application\CommandBus;


use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;
use Zend\ServiceManager\ServiceLocatorInterface;

class AppendLocator implements HandlerLocator
{
    /** @var  ServiceLocatorInterface */
    protected $serviceLocator;

    /**
     * AppendLocator constructor.
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }


    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getHandlerForCommand($commandName)
    {
        $handlerName = $commandName . 'Handler';

        if(! $this->serviceLocator->has($handlerName)){
            throw MissingHandlerException::forCommand($commandName);
        }

        return $this->serviceLocator->get($handlerName);
    }
}