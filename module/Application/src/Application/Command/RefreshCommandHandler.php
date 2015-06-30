<?php


namespace Application\Command;


use Application\Model\Mapper\RepositoryMapperAwareInterface;
use Application\Model\Mapper\RepositoryMapperAwareTrait;

class RefreshCommandHandler implements RepositoryMapperAwareInterface
{
    use RepositoryMapperAwareTrait;

    public function __invoke(RefreshCommand $command)
    {
        $model = $this->getRepositoryMapper()->findByUrl($command->getUrl());
        if(! $model) {
            return;
        }

        $fp = fopen(__DIR__ . '/../../../../../data/refresh.log', 'a+');
        fwrite($fp, sprintf("Refreshing %s\n", $model->url));
        fclose($fp);
    }
}