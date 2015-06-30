<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:46 PM
 */

namespace Application\Exception;


use RuntimeException;

class CloneFailedException extends RuntimeException
{
    public static function fromReturnValue($code, $url)
    {
        return new CloneFailedException(sprintf("Failed to clone repository %s.", $url), $code);
    }
}