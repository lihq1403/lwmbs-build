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
namespace App\Utils;

use Github\Api\Repository\Actions\Workflows;

class GithubWorkflows extends Workflows
{
    public function active(string $username, string $repository, $workflow): array|string
    {
        if (is_string($workflow)) {
            $workflow = rawurlencode($workflow);
        }

        return $this->put('/repos/' . rawurlencode($username) . '/' . rawurlencode($repository) . '/actions/workflows/' . $workflow . '/enable');
    }
}
