<?php


namespace Application\Command;


use Application\Exception\CloneFailedException;
use Application\Exception\FetchFailedException;
use Application\Exception\LogFailedException;
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

        list($protocol, $uri) = explode('://', $model->url);
        $parsed = parse_url($uri);
        $host = $parsed['PHP_URL_HOST'];
        $project = rtrim(basename($parsed['PHP_URL_PATH']), '.git');

        $basePath = __DIR__ . '/../../../../../data/git';
        $path = sprintf('%s/%s/%s', $basePath, $host, $project);
        $currentDir = getcwd();

        if(!file_exists($path))
        {
            // clone
            $command = sprintf("git clone %s %s", $model->url, $path);
            exec($command, $output, $return_value);
            if($return_value !== 0)
            {
                throw CloneFailedException::fromReturnValue($return_value, $model->url);
            }

            chdir($path);

            // checkout
            // todo
        } else {
            // fetch / pull
            chdir($path);
            $command = sprintf("git fetch");
            exec($command, $output, $return_value);
            if($return_value !== 0)
            {
                chdir($currentDir);
                throw FetchFailedException::fromReturnValue($return_value, $model->url);
            }
            // pull
            // todo
        }

        // git log & parse
        $count_command = sprintf("git rev-list HEAD --count");
        exec($count_command, $output, $return_value);
        if($return_value !== 0) {
            throw new LogFailedException("Failed to get number of commits", $return_value);
        }

        // git log -n 25 until executions > commit count
        $remain = (int) $output[0];
        $perPage = 25;
        $skip = 0;
        do {
            $command = sprintf("git log -n %s --skip=%s --name-status", $perPage, $skip);
            exec($command, $output, $return_value);
            if($return_value !== 0)
            {
                throw new LogFailedException(sprintf("Failed to get %s commits after %s", $perPage, $skip));
            }

            // parse output

            $skip += $perPage;
            $remain -= $perPage;
        } while ($remain > 0);

        $fp = fopen(__DIR__ . '/../../../../../data/refresh.log', 'a+');
        fwrite($fp, sprintf("Refreshed %s\n", $model->url));
        fclose($fp);
    }
}