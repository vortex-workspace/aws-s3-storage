<?php

namespace AwsStorage;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use AwsStorage\S3Drive\Exceptions\FailedToGetS3Object;
use AwsStorage\S3Drive\Traits\Appends;
use AwsStorage\S3Storage\Exceptions\MissingAwsS3Bucket;
use GuzzleHttp\Exception\ClientException;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToReadFile;
use MissingAwsS3Setting;
use Stellar\Boot\Application;
use Stellar\Settings\Exceptions\InvalidSettingException;
use Stellar\Storage\Exceptions\DriveNotDefined;
use Stellar\Storage\StorageDrive;

class S3Drive extends StorageDrive
{
    use Appends;

    private const string ACCESS_KEY = 'access_key';
    private const string SECRET_KEY = 'secret_key';
    private const string REGION = 'region';
    private const string ENDPOINT = 'endpoint';
    private const string USE_SSL = 'use_ssl';
    private const string BUCKET = 'bucket';

    private ?string $bucket;
    private ?string $region;
    private ?string $endpoint;
    private ?bool $use_ssl;
    private array $drive_settings = [];

    public function __construct(
        ?string $drive = null,
        ?string $bucket = null,
        ?string $region = null,
        ?string $endpoint = null,
        ?bool   $use_ssl = null,
    )
    {
        parent::__construct($drive, 'public');
        $this->bucket = $bucket;
        $this->region = $region;
        $this->endpoint = $endpoint;
        $this->use_ssl = $use_ssl;
    }

    public function bucket(string $bucket): static
    {
        $this->bucket = $bucket;

        return $this;
    }

    public function region(string $region): static
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @param string $endpoint
     * @return $this
     */
    public function endpoint(string $endpoint): static
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @param string $path
     * @return string|bool
     * @throws DriveNotDefined
     * @throws FailedToGetS3Object
     * @throws InvalidSettingException
     * @throws MissingAwsS3Bucket
     * @throws MissingAwsS3Setting
     */
    public function get(string $path): string|bool
    {
        $this->setupDriveSettings();

        try {
            return $this->filesystem->read($path);
        } catch (FilesystemException|ClientException|S3Exception|UnableToReadFile $exception) {
            if ($this->exception_mode === true) {
                throw new FailedToGetS3Object($path, $exception->getMessage());
            }

            return false;
        }
    }

    /**
     * @return void
     * @throws DriveNotDefined
     * @throws InvalidSettingException
     * @throws MissingAwsS3Bucket
     * @throws MissingAwsS3Setting
     */
    private function setupDriveSettings(): void
    {
        $this->setDriveSettings($this->drive);

        $this->filesystem = Application::getInstance()
            ->getFilesystem(new AwsS3V3Adapter(
                new S3Client($this->mountClientArguments()),
                $this->drive_settings[self::BUCKET]
            ));
    }

    /**
     * @param string $drive
     * @return void
     * @throws DriveNotDefined
     * @throws InvalidSettingException
     * @throws MissingAwsS3Bucket
     * @throws MissingAwsS3Setting
     */
    protected function setDriveSettings(string $drive): void
    {
        $this->drive_settings = parent::getDriveSettings($drive);
        $this->appendCredentials()
            ->appendBucket()
            ->appendRegion()
            ->appendEndpoint()
            ->appendUseSsl();
    }

    private function mountClientArguments(): array
    {
        $arguments = [
            'region' => $this->drive_settings[self::REGION],
            'endpoint' => $this->drive_settings[self::ENDPOINT],
            'credentials' => [
                'key' => $this->drive_settings[self::ACCESS_KEY],
                'secret' => $this->drive_settings[self::SECRET_KEY],
            ],
        ];

        if (isset($this->drive_settings[self::ENDPOINT]) && !empty($this->drive_settings[self::ENDPOINT])) {
            $arguments['endpoint'] = $this->drive_settings[self::ENDPOINT];
        }

        return $arguments;
    }
}