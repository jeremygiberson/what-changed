<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:20 PM
 */

namespace Application\Model\Mapper;


use Application\Model\CommitLog;

class CommitLogMapper extends AbstractMapper
{
    public function save(CommitLog $model)
    {
        $this->internalSave($model);
    }
}