<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 9:57 AM
 */

namespace Application\Model;


use DateTime;
use DateTimeZone;

class Commit extends AbstractModel
{
    /** @var  int */
    public $commit_id;
    /** @var  int */
    public $repository_id;
    /** @var  string */
    public $commit_hash;
    /** @var  string */
    public $commit_date;
    /** @var  string */
    public $commit_author;
    /** @var  string */
    public $commit_message;

    /** @var  CommitFileStatus[] */
    private $commit_file_statuses;
    /** @var  Repository */
    private $repository;

    /**
     * Commit constructor.
     */
    public function __construct()
    {
        $this->commit_file_statuses = [];
    }

    /**
     * @param CommitFileStatus $fileStatus
     */
    public function addCommitFileStatus(CommitFileStatus $fileStatus)
    {
        $this->commit_file_statuses[] = $fileStatus;
    }

    /**
     * @return CommitFileStatus[]
     */
    public function getCommitFileStatuses()
    {
        return $this->commit_file_statuses;
    }

    /**
     * @return DateTime
     */
    public function getCommitDate()
    {
        return new DateTime($this->commit_date, new DateTimeZone('UTC'));
    }

    /**
     * @param DateTime $commit_date
     * @return self
     */
    public function setCommitDate(DateTime $commit_date)
    {
        $this->commit_date = $commit_date->format(DateTime::W3C);
        return $this;
    }

    /**
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param Repository $repository
     * @return self
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }


}
