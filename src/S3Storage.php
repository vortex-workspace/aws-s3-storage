<?php

namespace AwsStorage;

use AwsStorage\S3Storage\Exceptions\MissingAwsS3Setting;
use Stellar\Settings\Exceptions\InvalidSettingException;
use Stellar\Storage;

class S3Storage extends Storage
{
    /**
     * @param string $bucket
     * @return S3Drive
     * @throws InvalidSettingException
     */
    public static function bucket(string $bucket): S3Drive
    {
        return (new S3Drive(bucket: $bucket));
    }

    /**
     * @param string $region
     * @return S3Drive
     * @throws InvalidSettingException
     */
    public static function region(string $region): S3Drive
    {
        return (new S3Drive(region: $region));
    }

    /**
     * @param string $endpoint
     * @return S3Drive
     * @throws InvalidSettingException
     */
    public static function endpoint(string $endpoint): S3Drive
    {
        return (new S3Drive(endpoint: $endpoint));
    }

    /**
     * @param bool $use_ssl
     * @return S3Drive
     * @throws InvalidSettingException
     */
    public static function useSsl(bool $use_ssl): S3Drive
    {
        return (new S3Drive(use_ssl: $use_ssl));
    }

    /**
     * @param string $drive
     * @return S3Drive
     * @throws InvalidSettingException
     */
    public static function drive(string $drive): S3Drive
    {
        return (new S3Drive(drive: $drive));
    }

    /**
     * @param string $path
     * @return string|bool
     * @throws InvalidSettingException
     * @throws S3Drive\Exceptions\FailedToGetS3Object
     * @throws S3Storage\Exceptions\MissingAwsS3Bucket
     * @throws Storage\Exceptions\DriveNotDefined
     * @throws MissingAwsS3Setting
     */
    public static function get(string $path): string|bool
    {
        return (new S3Drive)->get($path);
    }
}