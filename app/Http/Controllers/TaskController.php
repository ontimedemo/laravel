<?php

namespace App\Http\Controllers;

use App\Model\Task;
use App\Model\User;
use App\Traits\APIResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends BaseController
{
    use APIResponse;

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $tasks = Task::with('project')->where('assigned_to', '=', $this->getUser()->id)->get();
            return $this->apiResponse($tasks);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param int $task
     * @return JsonResponse
     */
    public function get(int $task): JsonResponse
    {
        try {
            $task = Task::with('project')->where('id', '=', $task)->get();
            return $this->apiResponse($task);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'project_id' => 'integer|required',
                'name' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->apiError($validator->getMessageBag()->all());
            }
            $data = array_merge($request->all(), ['created_by' => $this->getUser()->id, 'status' => 'todo']);
            $task = Task::create($data);
            return $this->apiResponse($task);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param int $task
     * @return JsonResponse
     */
    public function update(Request $request, int $task)
    {
        try {
            $task = Task::findOrFail($task);
            $task->update($request->all());
            return $this->apiResponse($task);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param int $task
     * @return JsonResponse
     */
    public function assign(Request $request, int $task)
    {
        try {
            $task = Task::findOrFail($task);
            $user = User::findOrFail($request->get('user_id'));
            $task->assigned_to = $user->id;
            $task->update();
            return $this->apiResponse($task);
        } catch (\Throwable $e) {
            return $this->apiError($e->getMessage());
        }
    }
}
