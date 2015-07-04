<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:20 PM
 */

namespace Application\Model\Mapper;


use Application\Model\Commit;

class CommitLogMapper extends AbstractMapper
{
    public function save(Commit $model)
    {
        $this->internalSave($model);
    }
}