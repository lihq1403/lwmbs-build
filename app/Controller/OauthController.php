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

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class OauthController extends Controller
{
    public function login(): PsrResponseInterface
    {
        $state = $this->auth->generateLoginState();
        return $this->response->redirect($this->githubClient->loginUrl($state));
    }

    public function logout(): PsrResponseInterface
    {
        $this->auth->logout();
        $this->setSuccessFlashMessage('退出成功');
        return $this->response->redirect('/');
    }

    public function redirect(): PsrResponseInterface
    {
        $code = $this->request->input('code');
        $state = $this->request->input('state');
        if (! $this->auth->isCorrectLoginState($state)) {
            $this->setFailFlashMessage('登录失败 state error');
            return $this->response->redirect('/');
        }

        $token = $this->githubClient->tokenFromCode($code);
        $user = $this->githubClient->getCurrentUser($token);
        $this->auth->login($user, $token);
        $this->setSuccessFlashMessage('登录成功');
        return $this->response->redirect('/');
    }
}
