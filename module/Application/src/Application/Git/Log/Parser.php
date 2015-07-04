<?php


namespace Application\Git\Log;


use Application\Model\Commit;
use Application\Model\CommitFileStatus;
use DateTime;
use DateTimeZone;

class Parser
{
    /** @var  Commit[] */
    private $commits;
    /** @var  Commit */
    private $current_commit;


    public function parse($lines)
    {
        $this->commits = [];
        $this->current_commit = null;

        // process any leading lines of output until we reach
        // first commit
        while(strpos($lines[0], 'commit') !== 0)
        {
            array_shift($lines);
        }

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
                case (strpos($line, ' ') === 0):
                    $this->handleMessage($line);
                    break;
                break;
                case preg_match('/(M|A|D|R|C|U)\x09/', $line):
                    $this->handleNameStatus($line);
                    break;
                default:
                    continue;
            }
        }

        return $this->commits;
    }

    private function handleCommit($line)
    {
        $this->current_commit = new Commit();
        $this->current_commit->commit_hash = substr($line, strlen('commit '));
        $this->commits[] = $this->current_commit;
    }

    private function handleMerge($merge)
    {
        // no-op
    }

    private function handleAuthor($line)
    {
        $this->current_commit->commit_author = substr($line, strlen('Author: '));
    }

    private function handleDate($line)
    {
        $dateTime = new DateTime(substr($line, strlen('Date: ')),
            New DateTimeZone('utc'));
        $this->current_commit->commit_date = $dateTime;
    }

    private function handleMessage($line)
    {
        $this->current_commit->commit_message .= ltrim($line);
    }

    private function handleNameStatus($line)
    {
        $fileStatus = new CommitFileStatus();
        $fileStatus->status = substr($line, 0, 1);
        $fileStatus->name = ltrim(substr($line, 1));
        $this->current_commit->addCommitFileStatus($fileStatus);
    }
}