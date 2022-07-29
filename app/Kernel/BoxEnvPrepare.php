<?php

namespace App\Kernel;

use Dotenv\Dotenv;
use Dotenv\Repository\RepositoryBuilder;
use Dotenv\Repository\Adapter;

class BoxEnvPrepare
{
    public static function init()
    {
        $tempPath = getenv('HOME') . '/.lwmbs-build';
        if (! is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }
        ! defined('TEMP_PATH') && define('TEMP_PATH', $tempPath);

        if (file_exists(TEMP_PATH . '/.env')) {
            static::loadDotenv();
        }
    }

    protected static function loadDotenv(): void
    {
        $repository = RepositoryBuilder::createWithNoAdapters()
            ->addAdapter(Adapter\PutenvAdapter::class)
            ->immutable()
            ->make();

        Dotenv::create($repository, [TEMP_PATH])->load();
    }
}