<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:21 PM
 */

namespace Application\Model\Mapper;


use Application\Model\CommitFileStatus;

class CommitFileStatusMapper extends AbstractMapper
{
    public function save(CommitFileStatus $model)
    {
        $this->internalSave($model);
    }
}