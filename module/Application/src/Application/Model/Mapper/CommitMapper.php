<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:20 PM
 */

namespace Application\Model\Mapper;


use Application\Model\Commit;

class CommitMapper extends AbstractMapper implements CommitFileStatusMapperAwareInterface
{
    use CommitFileStatusMapperAwareTrait;

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
}