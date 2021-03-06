<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:20 PM
 */

namespace Application\Model\Mapper;


use Application\Model\Commit;
use Application\Paginator\CommitPaginator;
use Zend\Db\Sql\Where;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Adapter\DbTableGateway;
use Zend\Paginator\Paginator;

class CommitMapper extends AbstractMapper
    implements CommitFileStatusMapperAwareInterface, RepositoryMapperAwareInterface
{
    use CommitFileStatusMapperAwareTrait;
    use RepositoryMapperAwareTrait;

    const MATCH_CONTAINS = '%%%s%%';
    const MATCH_BEGINS = '%s%%';
    const MATCH_ENDS = '%%%s';

    public function save(Commit $model)
    {
        $this->internalSave($model);

        foreach($model->getCommitFileStatuses() as $fileStatus)
        {
            $fileStatus->commit_id = $model->commit_id;
            $this->getCommitFileStatusMapper()->save($fileStatus);
        }
    }

    public function hasCommit($hash)
    {
        $result = $this->getTableGateway()->select([
            'commit_hash' => $hash
        ]);
        return $result->count() > 0;
    }

    /**
     * @return Paginator
     */
    public function getList()
    {
        $gatewayAdapter = new DbTableGateway($this->getTableGateway());
        $paginator = new CommitPaginator($gatewayAdapter);
        $paginator->setCommitFileStatusMapper($this->getCommitFileStatusMapper());
        $paginator->setRepositoryMapper($this->getRepositoryMapper());

        return $paginator;
    }

    /**
     * @param string $message
     * @param string $match_pattern
     * @return Paginator
     */
    public function matchingMessage($message, $match_pattern = self::MATCH_CONTAINS)
    {
        $where = new Where();
        $where->like('commit-message', sprintf($match_pattern, $message));

        $gatewayAdapter = new DbTableGateway($this->getTableGateway(), $where);
        $paginator = new CommitPaginator($gatewayAdapter);
        $paginator->setCommitFileStatusMapper($this->getCommitFileStatusMapper());
        $paginator->setRepositoryMapper($this->getRepositoryMapper());

        return $paginator;
    }

    /**
     * @param string $filename
     * @param string $match_pattern
     * @return Paginator
     */
    public function matchingFilename($filename, $match_pattern = self::MATCH_CONTAINS)
    {
        $select = $this->getTableGateway()->getSql()->select();
        $select->join(['file' => 'commit_file_status'], 'commit.commit_id = file.commit_id', []);

        $where = new Where();
        $where->like('file.name', sprintf($match_pattern, $filename));
        $select->where($where);

        $selectAdapter = new DbSelect($select, $this->adapter, $this->getTableGateway()->getResultSetPrototype());

        $paginator = new CommitPaginator($selectAdapter);
        $paginator->setCommitFileStatusMapper($this->getCommitFileStatusMapper());
        $paginator->setRepositoryMapper($this->getRepositoryMapper());

        return $paginator;
    }
}