<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 9:57 AM
 */

namespace Application\Model;


use DateTime;

class Commit extends AbstractModel
{
    /** @var  int */
    public $commit_id;
    /** @var  int */
    public $repository_id;
    /** @var  string */
    public $commit_hash;
    /** @var  DateTime */
    public $commit_date;
    /** @var  string */
    public $commit_author;
    /** @var  string */
    public $commit_message;

    /** @var  CommitFileStatus[] */
    private $commit_file_statuses;

    /**
     * Commit constructor.
     */
    public function __construct()
    {
        $this->commit_file_statuses = [];
    }


    public function addCommitFileStatus($fileStatus)
    {
        $this->commit_file_statuses[] = $fileStatus;
    }
}