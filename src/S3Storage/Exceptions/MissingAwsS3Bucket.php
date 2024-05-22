<?php

namespace AwsStorage\S3Storage\Exceptions;

use Monolog\Level;
use Stellar\Throwable\Exceptions\Contracts\Exception;
use Stellar\Throwable\Exceptions\Enum\ExceptionCode;

class MissingAwsS3Bucket extends Exception
{
    function __construct()
    {
        parent::__construct(
            "Missing Aws S3 bucket.",
            ExceptionCode::NON_CATCH_EXCEPTION,
            Level::Error
        );
    }
}