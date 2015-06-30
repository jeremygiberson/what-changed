<?php


namespace Application\Exception;


use Zend\Http\Client\Exception\RuntimeException;

class CannotAccessUrlException extends RuntimeException
{
    public static function fromReturnValue($code)
    {
        return new CannotAccessUrlException(
            sprintf("Could not access repository"),
            $code);
    }
}