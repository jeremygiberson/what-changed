<?php


namespace Application\Paginator;


use Application\Model\Commit;
use Application\Model\Mapper\CommitFileStatusMapperAwareInterface;
use Application\Model\Mapper\CommitFileStatusMapperAwareTrait;
use Zend\Paginator\Paginator;

class CommitPaginator extends Paginator implements CommitFileStatusMapperAwareInterface
{
    use CommitFileStatusMapperAwareTrait;

    public function getCurrentItems()
    {
        /** @var Commit[] $commits */
        $commits = parent::getCurrentItems();

        foreach ($commits as $commit) {
            foreach ($this->getCommitFileStatusMapper()->forCommit($commit) as $status) {
                $commit->addCommitFileStatus($status);
            }
        }

        return $commits;
    }

}