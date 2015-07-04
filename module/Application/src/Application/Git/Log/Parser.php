<?php


namespace Application\Git\Log;


use Application\Model\Commit;

class Parser
{
    /** @var  Commit[] */
    private $commits;
    /** @var  Commit */
    private $current_commit;
    public function parse($lines)
    {
        foreach($lines as $line)
        {
            switch(true)
            {
                case (strpos($line, 'commit ') === 0):
                    $this->handleCommit($line);
                    break;
                case (strpos($line, 'Merge: ') === 0):
                    $this->handleMerge($line);
                    break;
                case (strpos($line, 'Author: ') === 0):
                    $this->handleAuthor($line);
                    break;
                case (strpos($line, 'Date: ') === 0):
                    $this->handleDate($line);
                    break;
                case (strpos($line, "\t") === 0):
                    $this->handleMessage($line);
                break;
                default:
                    continue;
            }
        }
    }

    private function handleCommit($line)
    {
    }

    private function handleMerge($merge)
    {
    }

    private function handleAuthor($line)
    {
    }

    private function handleDate($line)
    {
    }

    private function handleMessage($line)
    {
    }
}