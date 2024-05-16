<?php


use Monolog\Level;
use Stellar\Throwable\Exceptions\Contracts\Exception;
use Stellar\Throwable\Exceptions\Enum\ExceptionCode;

class MissingAwsS3Setting extends Exception
{
    function __construct(string $key)
    {
        parent::__construct(
            "Missing or invalid Aws S3 key \"$key\".",
            ExceptionCode::NON_CATCH_EXCEPTION,
            Level::Error
        );
    }
}