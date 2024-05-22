<?php

namespace AwsStorage\S3Drive\Exceptions;

use Monolog\Level;
use Stellar\Throwable\Exceptions\Contracts\Exception;
use Stellar\Throwable\Exceptions\Enum\ExceptionCode;

class FailedToGetUrlFromS3Object extends Exception
{
    function __construct(string $path, string $message)
    {
        parent::__construct(
            "Failed to get Aws S3 object url from path \"$path\". response: \"$message\".",
            ExceptionCode::NON_CATCH_EXCEPTION,
            Level::Error
        );
    }
}