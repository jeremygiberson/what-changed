<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:25 PM
 */

namespace Application\Model\Mapper;

/**
 * Class CommitMapperAwareTrait
 * @package Application\Model\Mapper
 * @satisfies CommitMapperAwareInterface
 */
trait CommitMapperAwareTrait
{
    /** @var  CommitMapper */
    private $commitMapper;

    /**
     * @return CommitMapper
     */
    public function getCommitMapper()
    {
        return $this->commitMapper;
    }

    /**
     * @param CommitMapper $commitLogMapper
     * @return CommitMapperAwareTrait
     */
    public function setCommitMapper(CommitMapper $commitLogMapper)
    {
        $this->commitMapper = $commitLogMapper;
        return $this;
    }


}