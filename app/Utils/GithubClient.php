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

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use Github\AuthMethod;
use Github\Client;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\RequestOptions;

class GithubClient
{
    protected Client $client;

    protected GuzzleHttpClient $httpClient;

    protected array $config;

    public function __construct()
    {
        $this->httpClient = new GuzzleHttpClient();
        $this->client = Client::createWithHttpClient($this->httpClient);
        $this->config = config('github_oauth_app');
    }

    public function loginUrl(string $state): string
    {
        $options = [
            'client_id' => $this->config['client_id'],
            'redirect_uri' => $this->config['redirect_uri'],
            'scope' => 'read:user public_repo',
            'state' => $state,
        ];
        return 'https://github.com/login/oauth/authorize?' . http_build_query($options);
    }

    public function tokenFromCode(string $code): string
    {
        $url = 'https://github.com/login/oauth/access_token';
        $body = [
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'code' => $code,
            'redirect_uri' => $this->config['redirect_uri'],
        ];
        $response = $this->httpClient->post($url, [
            RequestOptions::JSON => $body,
        ]);
        if ($response->getStatusCode() != 200) {
            throw new BusinessException(ErrorCode::LOGIN_ERROR, 'login fail');
        }
        $responseContent = $response->getBody()->getContents();
        parse_str($responseContent, $result);
        if (empty($result['access_token'])) {
            throw new BusinessException(ErrorCode::LOGIN_ERROR, 'login fail.');
        }
        return $result['access_token'];
    }

    public function getCurrentUser(string $token): array
    {
        $this->client->authenticate($token, null, AuthMethod::ACCESS_TOKEN);
        return $this->client->currentUser()->show();
    }

    public function repoExist(string $username, string $repository): bool
    {
        try {
            $this->client->repo()->show($username, $repository);
        } catch (\Throwable $throwable) {
            return false;
        }
        return true;
    }

    public function fork(string $token, string $owner, string $repo, string $forkedRepo = ''): array|string
    {
        $params = [];
        if (! empty($forkedRepo)) {
            $params = [
                'name' => $forkedRepo,
            ];
        }
        $this->client->authenticate($token, null, AuthMethod::ACCESS_TOKEN);
        return $this->client->repo()->forks()->create($owner, $repo, $params);
    }

    public function workflowList(string $username, string $repository): array
    {
        return $this->client->repo()->workflows()->all($username, $repository);
    }

    public function workflowActive($token, string $username, string $repository, int $workflow): void
    {
        $this->client->authenticate($token, null, AuthMethod::ACCESS_TOKEN);
        $this->workflows()->active($username, $repository, $workflow);
    }

    public function workflowDispatches(string $token, string $username, string $repository, $workflow, string $ref, array $inputs = null)
    {
        $this->client->authenticate($token, null, AuthMethod::ACCESS_TOKEN);
        $this->client->repo()->workflows()->dispatches($username, $repository, $workflow, $ref, $inputs);
    }

    private function workflows(): GithubWorkflows
    {
        return new GithubWorkflows($this->client);
    }
}
