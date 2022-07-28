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

use Hyperf\View\RenderInterface;

class IndexController extends Controller
{
    public function index(RenderInterface $render)
    {
        return $render->render('index', [
            'auth' => $this->auth,
            'allow_extensions' => array_keys(config('lwmbs.allow_extensions')),
            'allow_libraries' => array_keys(config('lwmbs.allow_libraries')),
            'allow_workflows' => array_keys(config('lwmbs.allow_workflows')),
            'source_repo_name' => config('lwmbs.source_repo.owner') . '/' . config('lwmbs.source_repo.repo'),
            'forked_repo_name' => $this->auth->owner() . '/' . config('lwmbs.source_repo.repo'),
            'flash_response' => $this->getFlashResponse(),
        ]);
    }
}
