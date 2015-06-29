<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/29/15 2:36 PM
 */

namespace Application\Controller;


use Application\Command\RespondToWebHookCommand;
use Application\CommandBus\CommandBusAwareInterface;
use Application\CommandBus\CommandBusAwareTrait;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

class GitlabController extends AbstractActionController implements CommandBusAwareInterface
{
    use CommandBusAwareTrait;

    public function hookAction()
    {
        $json = json_decode($this->getRequest()->getContent());

        $command = new RespondToWebHookCommand($json->repository->url);

        $this->getCommandBus()->handle($command);

        return new Response();
    }
}
