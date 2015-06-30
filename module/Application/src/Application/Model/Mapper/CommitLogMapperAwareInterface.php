<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:24 PM
 */

namespace Application\Model\Mapper;


interface CommitLogMapperAwareInterface
{
    /**
     * @param CommitLogMapper $mapper
     */
    public function setCommitLogMapper(CommitLogMapper $mapper);

    /**
     * @return CommitLogMapper
     */
    public function getCommitLogMapper();
}