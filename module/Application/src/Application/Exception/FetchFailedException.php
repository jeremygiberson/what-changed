<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:45 PM
 */

namespace Application\Exception;


use RuntimeException;

class FetchFailedException extends RuntimeException
{
    public static function fromReturnValue($code, $url)
    {
        return new FetchFailedException(sprintf("Failed to fetch for repository %s.", $url), $code);
    }
}