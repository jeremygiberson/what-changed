<?php


namespace Application\Paginator;


use Application\Model\Commit;
use Application\Model\Mapper\CommitFileStatusMapperAwareInterface;
use Application\Model\Mapper\CommitFileStatusMapperAwareTrait;
use Application\Model\Mapper\RepositoryMapperAwareInterface;
use Application\Model\Mapper\RepositoryMapperAwareTrait;
use Zend\Paginator\Paginator;

class CommitPaginator extends Paginator
    implements CommitFileStatusMapperAwareInterface, RepositoryMapperAwareInterface
{
    use CommitFileStatusMapperAwareTrait;
    use RepositoryMapperAwareTrait;

    public function getCurrentItems()
    {
        /** @var Commit[] $commits */
        $commits = parent::getCurrentItems();

        foreach ($commits as $commit) {
            foreach ($this->getCommitFileStatusMapper()->forCommit($commit) as $status) {
                $commit->addCommitFileStatus($status);
            }

            $commit->setRepository($this->getRepositoryMapper()->findById($commit->repository_id));
        }

        return $commits;
    }

}