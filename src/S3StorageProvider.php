<?php

namespace AwsStorage;

use Stellar\Provider;

class S3StorageProvider extends Provider
{
    public const string ENVIRONMENT_AWS_ACCESS_KEY = 'AWS_ACCESS_KEY';
    public const string ENVIRONMENT_AWS_SECRET_KEY = 'AWS_SECRET_KEY';
    public const string ENVIRONMENT_AWS_REGION = 'AWS_REGION';
    public const string ENVIRONMENT_AWS_ENDPOINT = 'AWS_ENDPOINT';
    public const string ENVIRONMENT_AWS_STORAGE_BUCKET = 'AWS_STORAGE_BUCKET';
    public const string ENVIRONMENT_AWS_USE_SSL = 'AWS_USE_SSL';
    public const string DEFAULT_REGION = 'eu-west-2';

    public static function gateways(): array
    {
        return [
            StorageS3Gateway::class,
        ];
    }

    public static function settings(): array
    {
        return [__DIR__ . '/../settings/s3.php'];
    }
}