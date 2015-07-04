<?php


namespace Application\Controller;


use Application\Command\RefreshCommand;
use Application\CommandBus\CommandBusAwareInterface;
use Application\CommandBus\CommandBusAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;

class ConsoleController extends AbstractActionController implements CommandBusAwareInterface
{
    use CommandBusAwareTrait;

    public function refreshAction()
    {
        $url = $this->params()->fromRoute('url');
        $command = new RefreshCommand($url);

        $this->getCommandBus()->handle($command);

        return "done\n";
    }
}