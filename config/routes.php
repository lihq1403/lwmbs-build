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
use Hyperf\HttpServer\Router\Router;

Router::get('/', [\App\Controller\IndexController::class, 'index']);

Router::get('/oauth/login', [\App\Controller\OauthController::class, 'login']);
Router::get('/oauth/redirect', [\App\Controller\OauthController::class, 'redirect']);
Router::get('/oauth/logout', [\App\Controller\OauthController::class, 'logout']);

Router::post('/workflow/run', [\App\Controller\WorkflowController::class, 'run']);
