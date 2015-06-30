<?php


namespace Application\Controller;


use Application\Command\RegisterCommand;
use Application\CommandBus\CommandBusAwareInterface;
use Application\CommandBus\CommandBusAwareTrait;
use Application\Exception\CannotAccessUrlException;
use Application\Form\RegisterRepository;
use Application\Model\Repository;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;

class RegistrationController extends AbstractActionController implements CommandBusAwareInterface
{
    use CommandBusAwareTrait;

    public function registerAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();

        $form = new RegisterRepository();
        $form->bind($repository = new Repository());

        if($request->isPost())
        {
            $form->setData($request->getPost());

            if($form->isValid())
            {
                $command = new RegisterCommand($repository->url);

                try {
                    $this->getCommandBus()->handle($command);
                    $this->redirect()->toRoute('application');
                } catch (CannotAccessUrlException $e) {
                    $form->get('repository')->get('url')->setMessages([
                        'unable to access this repository'
                    ]);
                }
            }
        }

        return ['form' => $form];
    }
}
