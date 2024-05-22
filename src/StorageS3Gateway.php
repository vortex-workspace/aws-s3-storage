<?php

namespace AwsStorage;

use Stellar\Adapters\StorageAdapter;
use Stellar\Gateway;
use Stellar\Gateway\Method;

class StorageS3Gateway extends Gateway
{
    public static function adapterClass(): string
    {
        return StorageAdapter::class;
    }

    public static function staticMethods(): array
    {
        return [
            Method::make(
                'fromS3',
                function (
                    ?string        $drive = null,
                    ?string        $bucket = null,
                    ?string        $region = null,
                    ?string        $endpoint = null,
                    ?bool          $use_ssl = null
                ): S3Drive {
                    return new S3Drive($drive, $bucket, $region, $endpoint, $use_ssl);
                },
            ),
        ];
    }

    public static function nonStaticMethods(): array
    {
        return [];
    }
}