<?php


namespace Application\Command;


use Application\Exception\CannotAccessUrlException;
use Application\Model\Mapper\RepositoryMapperAwareInterface;
use Application\Model\Mapper\RepositoryMapperAwareTrait;
use Application\Model\Repository;

class RegisterCommandHandler implements RepositoryMapperAwareInterface
{
    use RepositoryMapperAwareTrait;

    public function __invoke(RegisterCommand $command)
    {
        if($this->getRepositoryMapper()->findByUrl($command->getUrl()))
        {
            return; // already registered
        }

        // make sure we can access the repository
        $shell_command = sprintf("git ls-remote -t %s", $command->getUrl());
        exec($shell_command, $output, $return_value);

        if($return_value !== 0)
        {
            throw CannotAccessUrlException::fromReturnValue($return_value);
        }

        $repository = new Repository();
        $repository->url = $command->getUrl();

        $this->getRepositoryMapper()->save($repository);
    }
}