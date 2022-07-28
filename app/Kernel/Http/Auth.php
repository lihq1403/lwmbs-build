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
namespace App\Kernel\Http;

use Hyperf\Contract\SessionInterface;

class Auth
{
    protected SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function isLogin(): bool
    {
        return boolval($this->user());
    }

    public function login(array $userInfo, string $token)
    {
        $this->session->set('user', $userInfo);
        $this->session->set('token', $token);
    }

    public function logout()
    {
        $this->session->clear();
    }

    public function user(): array
    {
        return $this->session->get('user', []);
    }

    public function owner(): string
    {
        return $this->session->get('user.login', '');
    }

    public function token(): string
    {
        return $this->session->get('token', '');
    }

    public function generateLoginState(): string
    {
        $state = uniqid('state_');
        $this->session->set('login_state', $state);
        return $state;
    }

    public function isCorrectLoginState(string $state): bool
    {
        if ($this->session->get('login_state') !== $state) {
            return false;
        }
        return true;
    }
}
