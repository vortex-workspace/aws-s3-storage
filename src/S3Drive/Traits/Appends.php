<?php

namespace AwsStorage\S3Drive\Traits;

use AwsStorage\S3Storage\Exceptions\MissingAwsS3Bucket;
use AwsStorage\S3StorageProvider;
use MissingAwsS3Setting;
use Stellar\Setting;
use Stellar\Settings\Exceptions\InvalidSettingException;

trait Appends
{
    /**
     * @return $this
     * @throws MissingAwsS3Setting
     */
    private function appendCredentials(): static
    {
        $this->drive_settings[self::ACCESS_KEY] = $this->drive_settings[self::ACCESS_KEY] ??
            env(S3StorageProvider::ENVIRONMENT_AWS_ACCESS_KEY);

        if (empty($this->drive_settings[self::ACCESS_KEY])) {
            throw new MissingAwsS3Setting(self::ACCESS_KEY);
        }

        $this->drive_settings[self::SECRET_KEY] = $this->drive_settings[self::SECRET_KEY] ??
            env(S3StorageProvider::ENVIRONMENT_AWS_SECRET_KEY);

        if (empty($this->drive_settings[self::SECRET_KEY])) {
            throw new MissingAwsS3Setting(self::SECRET_KEY);
        }

        return $this;
    }

    /**
     * @return $this
     * @throws InvalidSettingException
     */
    private function appendRegion(): static
    {
        $this->drive_settings[self::REGION] = $this->region ??
            $this->drive_settings[self::REGION] ??
            env(
                S3StorageProvider::ENVIRONMENT_AWS_REGION,
                Setting::get('s3.defaults.region', S3StorageProvider::DEFAULT_REGION)
            );

        return $this;
    }

    /**
     * @return $this
     * @throws InvalidSettingException
     */
    private function appendEndpoint(): static
    {
        $this->drive_settings[self::ENDPOINT] = $this->endpoint ??
            $this->drive_settings[self::ENDPOINT] ??
            env(
                S3StorageProvider::ENVIRONMENT_AWS_ENDPOINT,
                Setting::get('s3.defaults.endpoint')
            );

        return $this;
    }

    /**
     * @return $this
     * @throws InvalidSettingException
     * @throws MissingAwsS3Bucket
     */
    private function appendBucket(): static
    {
        $this->drive_settings[self::BUCKET] = $this->bucket ??
            $this->drive_settings[self::BUCKET] ??
            env(S3StorageProvider::ENVIRONMENT_AWS_STORAGE_BUCKET, Setting::get('s3.defaults.bucket'));

        if ($this->drive_settings[self::BUCKET] === null) {
            throw new MissingAwsS3Bucket;
        }

        return $this;
    }

    /**
     * @return void
     * @throws InvalidSettingException
     */
    private function appendUseSsl(): void
    {
        $this->drive_settings[self::USE_SSL] = $this->use_ssl ??
            $this->drive_settings[self::USE_SSL] ??
            env(S3StorageProvider::ENVIRONMENT_AWS_USE_SSL, Setting::get('s3.defaults.use_ssl'));
    }
}