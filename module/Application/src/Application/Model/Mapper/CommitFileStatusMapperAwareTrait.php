<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:26 PM
 */

namespace Application\Model\Mapper;

/**
 * Class CommitFileStatusMapperAwareTrait
 * @package Application\Model\Mapper
 * @satisfies CommitFileStatusMapperAwareInterface
 */
trait CommitFileStatusMapperAwareTrait
{
    /** @var  CommitFileStatusMapper */
    private $commitFileStatusMapper;

    /**
     * @return CommitFileStatusMapper
     */
    public function getCommitFileStatusMapper()
    {
        return $this->commitFileStatusMapper;
    }

    /**
     * @param CommitFileStatusMapper $commitFileStatusMapper
     * @return CommitFileStatusMapperAwareTrait
     */
    public function setCommitFileStatusMapper(CommitFileStatusMapper $commitFileStatusMapper)
    {
        $this->commitFileStatusMapper = $commitFileStatusMapper;
        return $this;
    }

}