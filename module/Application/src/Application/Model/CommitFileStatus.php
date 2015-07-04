<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 10:00 AM
 */

namespace Application\Model;


class CommitFileStatus extends AbstractModel
{
    /** @var  int */
    public $commit_file_status_id;
    /** @var  int */
    public $commit_id;
    /** @var  string */
    public $status;
    /** @var  string */
    public $name;
}