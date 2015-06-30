<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:26 PM
 */

namespace Application\Model\Mapper;


interface CommitFileStatusMapperAwareInterface
{
    /**
     * @param CommitFileStatusMapper $mapper
     */
    public function setCommitFileStatusMapper(CommitFileStatusMapper $mapper);

    /**
     * @return CommitFileStatusMapper
     */
    public function getCommitFileStatusMapper();
}