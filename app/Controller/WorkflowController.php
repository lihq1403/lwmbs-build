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

use Psr\Http\Message\ResponseInterface;

class WorkflowController extends Controller
{
    public function run(): ResponseInterface
    {
        if (! $this->auth->isLogin()) {
            $this->setFailFlashMessage('请先登录');
            return $this->response->redirect('/');
        }

        $params = $this->request->all();

        $allowWorkflows = config('lwmbs.allow_workflows');
        $libraries = $this->getCheckBoxOn($params, config('lwmbs.allow_libraries'), 'libraries_');
        $extensions = $this->getCheckBoxOn($params, config('lwmbs.allow_extensions'), 'extensions_');
        $workflows = $this->getCheckBoxOn($params, $allowWorkflows, 'workflows_');

        $sourceRepo = config('lwmbs.source_repo');
        $forkedRepoName = config('lwmbs.source_repo.repo');

        $message = '';
        try {
            // exist
            if (! $this->githubClient->repoExist($this->auth->owner(), $forkedRepoName)) {
                // fork
                $this->githubClient->fork($this->auth->token(), $sourceRepo['owner'], $sourceRepo['repo'], $forkedRepoName);
                $message .= "fork[{$sourceRepo['owner']}/{$sourceRepo['repo']}] success!";
            }

            // workflow
            $workflowsList = $this->githubClient->workflowList($this->auth->owner(), $forkedRepoName)['workflows'] ?? [];
            if (empty($workflowsList)) {
                $this->setFailFlashMessage("未检测到workflows，请前往 https://github.com/{$this->auth->owner()}/{$forkedRepoName}/actions 开启");
                return $this->response->redirect('/');
            }

            foreach ($workflows as $workflowName) {
                $workflowConfig = null;
                foreach ($allowWorkflows as $allowWorkflow) {
                    if ($allowWorkflow['name'] === $workflowName) {
                        $workflowConfig = $allowWorkflow;
                        break;
                    }
                }

                $workflow = [];
                foreach ($workflowsList as $workflowGithub) {
                    if ($workflowName === $workflowGithub['name']) {
                        $workflow = $workflowGithub;
                        break;
                    }
                }

                // active
                if ($workflow['state'] != 'active') {
                    $this->githubClient->workflowActive($this->auth->token(), $this->auth->owner(), $forkedRepoName, $workflow['id']);
                }

                $input = null;
                if ($workflowConfig['input_libraries'] ?? false) {
                    $input['libraries'] = implode(',', $libraries);
                }
                if ($workflowConfig['input_extensions'] ?? false) {
                    $input['extensions'] = implode(',', $extensions);
                }

                // dispatches
                $this->githubClient->workflowDispatches($this->auth->token(), $this->auth->owner(), $forkedRepoName, $workflow['id'], $workflowConfig['ref'], $input);
                $message .= "workflow[{$workflow['name']}] run success! ";
            }
        } catch (\Throwable $throwable) {
            $this->setFailFlashMessage($throwable->getMessage());
            return $this->response->redirect('/');
        }

        $this->setSuccessFlashMessage($message);
        return $this->response->redirect('/');
    }

    protected function getCheckBoxOn(array $params, array $allow, string $prefix): array
    {
        $items = [];
        foreach ($allow as $name => $item) {
            $key = $prefix . $name;
            if (isset($params[$key]) && $params[$key] === 'on') {
                $items[] = $item['name'];
            }
        }
        return $items;
    }
}
