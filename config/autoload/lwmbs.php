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
    'source_repo' => [
        'owner' => 'dixyes',
        'repo' => 'lwmbs',
    ],
    'allow_extensions' => [
        'iconv' => ['name' => 'iconv'],
        'dom' => ['name' => 'dom'],
        'xml' => ['name' => 'xml'],
        'simplexml' => ['name' => 'simplexml'],
        'xmlwriter' => ['name' => 'xmlwriter'],
        'xmlreader' => ['name' => 'xmlreader'],
        'opcache' => ['name' => 'opcache'],
        'bcmath' => ['name' => 'bcmath'],
        'pdo' => ['name' => 'pdo'],
        'phar' => ['name' => 'phar'],
        'mysqlnd' => ['name' => 'mysqlnd'],
        'mysqli' => ['name' => 'mysqli'],
        'pdo_mysql' => ['name' => 'pdo_mysql'],
        'mbstring' => ['name' => 'mbstring'],
        'mbregex' => ['name' => 'mbregex'],
        'session' => ['name' => 'session'],
        'ctype' => ['name' => 'ctype'],
        'fileinfo' => ['name' => 'fileinfo'],
        'filter' => ['name' => 'filter'],
        'tokenizer' => ['name' => 'tokenizer'],
        'curl' => ['name' => 'curl'],
        'ffi' => ['name' => 'ffi'],
        'swow' => ['name' => 'swow'],
        'redis' => ['name' => 'redis'],
        'parallel' => ['name' => 'parallel'],
        'sockets' => ['name' => 'sockets'],
        'openssl' => ['name' => 'openssl'],
        'zip' => ['name' => 'zip'],
        'zlib' => ['name' => 'zlib'],
        'bz2' => ['name' => 'bz2'],
        'yaml' => ['name' => 'yaml'],
        'zstd' => ['name' => 'zstd'],
    ],
    'allow_libraries' => [
        'zstd' => ['name' => 'zstd'],
        'libssh2' => ['name' => 'libssh2'],
        'curl' => ['name' => 'curl'],
        'zlib' => ['name' => 'zlib'],
        'brotli' => ['name' => 'brotli'],
        'libffi' => ['name' => 'libffi'],
        'openssl' => ['name' => 'openssl'],
        'libzip' => ['name' => 'libzip'],
        'bzip2' => ['name' => 'bzip2'],
        'nghttp2' => ['name' => 'nghttp2'],
        'onig' => ['name' => 'onig'],
        'libyaml' => ['name' => 'libyaml'],
        'xz' => ['name' => 'xz'],
        'libxml2' => ['name' => 'libxml2'],
    ],
    'allow_workflows' => [
        'cache_linux_environments' => [
            'name' => 'cache linux environments',
            'ref' => 'master',
            'input_extensions' => false,
            'input_libraries' => false,
        ],
        'linux_test' => [
            'name' => 'linux test',
            'ref' => 'master',
            'input_extensions' => true,
            'input_libraries' => true,
        ],
        'macos_test' => [
            'name' => 'macos test',
            'ref' => 'master',
            'input_extensions' => true,
            'input_libraries' => true,
        ],
        'windows_test' => [
            'name' => 'windows test',
            'ref' => 'master',
            'input_extensions' => true,
            'input_libraries' => true,
        ],
    ],
];
