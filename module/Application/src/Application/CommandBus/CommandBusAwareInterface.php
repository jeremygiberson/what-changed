<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/29/15 3:14 PM
 */

namespace Application\CommandBus;


use League\Tactician\CommandBus;

interface CommandBusAwareInterface
{
    /**
     * @param CommandBus $commandBus
     */
    public function setCommandBus(CommandBus $commandBus);

    /**
     * @return CommandBus
     */
    public function getCommandBus();
}