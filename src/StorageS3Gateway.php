<?php

namespace AwsStorage;

use Stellar\Gateway;
use Stellar\Gateway\Method;
use Stellar\Storage as StellarStorage;
use Stellar\Storage\Adapters\Storage;

class StorageS3Gateway extends Gateway
{
    public static function adapterClass(): string
    {
        return Storage::class;
    }

    public static function staticMethods(): array
    {
        return [
            Method::make(
                'fromS3',
                function (Storage $adapter): S3Storage {
                    return new S3Storage();
                },
            ),
        ];
    }

    public static function nonStaticMethods(): array
    {
        return [];
    }
}