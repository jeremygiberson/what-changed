<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/29/15 3:31 PM
 */

namespace Application\Command;


use Application\CommandBus\CommandBusAwareInterface;
use Application\CommandBus\CommandBusAwareTrait;
use Application\Model\Mapper\RepositoryMapperAwareInterface;
use Application\Model\Mapper\RepositoryMapperAwareTrait;

class RespondToWebHookCommandHandler implements CommandBusAwareInterface, RepositoryMapperAwareInterface
{
    use RepositoryMapperAwareTrait;
    use CommandBusAwareTrait;

    public function __invoke(RespondToWebHookCommand $command)
    {
        // verify repo url is something we are tracking
        $model = $this->getRepositoryMapper()->findByUrl($command->getUrl());
        if(! $model){
            return;
        }

        // queue refresh repo
        $queueCommand = new QueueRefreshCommand($command->getUrl());
        $this->getCommandBus()->handle($queueCommand);
    }
}