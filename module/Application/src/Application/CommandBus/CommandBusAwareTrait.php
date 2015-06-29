<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/29/15 3:14 PM
 */

namespace Application\CommandBus;


use League\Tactician\CommandBus;

/**
 * Class CommandBusAwareTrait
 * @package Application\CommandBus
 * @satisfies CommandBusAwareInterface
 */
trait CommandBusAwareTrait
{
    /** @var  CommandBus */
    private $commandBus;

    public function setCommandBus(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function getCommandBus(){
        return $this->commandBus;
    }
}