<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:25 PM
 */

namespace Application\Model\Mapper;

/**
 * Class CommitLogMapperAwareTrait
 * @package Application\Model\Mapper
 * @satisfies CommitLogMapperAwareInterface
 */
trait CommitLogMapperAwareTrait
{
    /** @var  CommitLogMapper */
    private $commitLogMapper;

    /**
     * @return CommitLogMapper
     */
    public function getCommitLogMapper()
    {
        return $this->commitLogMapper;
    }

    /**
     * @param CommitLogMapper $commitLogMapper
     * @return CommitLogMapperAwareTrait
     */
    public function setCommitLogMapper(CommitLogMapper $commitLogMapper)
    {
        $this->commitLogMapper = $commitLogMapper;
        return $this;
    }


}