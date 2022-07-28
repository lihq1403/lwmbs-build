<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'client_id' => env('GITHUB_APP_CLIENT_ID', ''),
    'client_secret' => env('GITHUB_APP_CLIENT_SECRET', ''),
    'redirect_uri' => env('GITHUB_APP_REDIRECT_URI', ''),
];
