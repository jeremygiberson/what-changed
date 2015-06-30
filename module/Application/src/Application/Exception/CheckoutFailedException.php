<?php
/**
 * @category WebPT
 * @copyright Copyright (c) 2015 WebPT, INC
 * @author jgiberson
 * 6/30/15 3:40 PM
 */

namespace Application\Exception;


use RuntimeException;

class CheckoutFailedException extends RuntimeException
{
    public static function fromReturnValue($code, $url)
    {
        return new CheckoutFailedException(sprintf("Failed to checkout repository %s.", $url), $code);
    }
}