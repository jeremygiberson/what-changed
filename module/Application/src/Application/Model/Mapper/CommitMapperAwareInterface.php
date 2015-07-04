<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:24 PM
 */

namespace Application\Model\Mapper;


interface CommitMapperAwareInterface
{
    /**
     * @param CommitMapper $mapper
     */
    public function setCommitMapper(CommitMapper $mapper);

    /**
     * @return CommitMapper
     */
    public function getCommitMapper();
}