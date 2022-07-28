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
namespace App\Controller;

use App\Kernel\Http\Auth;
use App\Kernel\Http\Response;
use App\Utils\GithubClient;
use Hyperf\Contract\SessionInterface;
use Hyperf\HttpServer\Contract\RequestInterface;

abstract class Controller
{
    protected Response $response;

    protected RequestInterface $request;

    protected SessionInterface $session;

    protected GithubClient $githubClient;

    protected Auth $auth;

    public function __construct(
        RequestInterface $request,
        Response $response,
        SessionInterface $session,
        Auth $auth,
        GithubClient $githubClient,
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
        $this->auth = $auth;
        $this->githubClient = $githubClient;
    }

    protected function setSuccessFlashMessage(string $message)
    {
        $this->session->set('success_flash_message', $message);
    }

    protected function setFailFlashMessage(string $message)
    {
        $this->session->set('fail_flash_message', $message);
    }

    protected function getFlashResponse(): array
    {
        return [
            'success_flash_message' => $this->session->remove('success_flash_message'),
            'fail_flash_message' => $this->session->remove('fail_flash_message'),
        ];
    }
}
